<?php

    class Baraniuk_Shares_Adminhtml_SharesController extends Mage_Adminhtml_Controller_Action {

        private $_share;

        public function _construct ()
        {
            Mage::getModel('baraniuk_shares/module');
            $this->_share = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->load($this->getRequest()->getParam('id'));
            parent::_construct();
        }

        public function indexAction()
        {
            $this->loadLayout();
            $this->_addContent($this->getLayout()->createBlock(BARANIUK_SHARES::ADMINHTML_BLOCK_SHARES));
            $this->renderLayout();

            return $this;
        }

        public function deleteAction () {

            $share = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->load($this->getRequest()->getParam('id'));

            $this->deletePhoto($share->getImage());

            $block = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)
                ->setId($this->getRequest()->getParam('id'))
                ->delete();

            $this->massProductsDelete($share->getId());

            if($block->getId()) {
                Mage::getSingleton('adminhtml/session')->addSuccess('Block was deleted successfully!');
            }

            $this->_redirect('*/*/');

            return $this;
        }

        public function newAction () {
            $this->loadLayout();
            $this->_addContent($this->getLayout()->createBlock(BARANIUK_SHARES::ADMINHTML_BLOCK_EDIT))
                ->_addLeft($this->getLayout()->createBlock(BARANIUK_SHARES::ADMINHTML_BLOCK_EDIT_TABS));
            $this->renderLayout();

            return $this;
        }

        public function massDeleteAction()
        {

            try {
                $shares = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)
                    ->getCollection()
                    ->addFieldToFilter('id', $this->getRequest()->getParam('ids'));
                foreach($shares as $share) {
                    $this->deletePhoto($share->getImage());
                    $share->delete();
                    $this->massProductsDelete($share->getId());
                }
            } catch(Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return $this->_redirect('*/*/');
            }

            Mage::getSingleton('adminhtml/session')->addSuccess('Blocks were deleted!');

            return $this->_redirect('*/*/');

        }

        public function massProductsDelete ($shareId) {
            $attachedProducts = Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS)
                ->getCollection()
                ->addFieldToFilter('action_id', $shareId);
            foreach($attachedProducts as $product) {
                $product->delete();
            }
        }

        public function editAction () {
            $this->loadLayout();

            $this->_addContent($this->getLayout()->createBlock(BARANIUK_SHARES::ADMINHTML_BLOCK_EDIT))
                ->_addLeft($this->getLayout()->createBlock(BARANIUK_SHARES::ADMINHTML_BLOCK_EDIT_TABS));

            $this->renderLayout();

            return $this;
        }

        public function saveAction() {
            try {

                $share = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->load($this->getRequest()->getParam('id'));

//                $this->setDates($share);

                $share
                    ->setData($this->getRequest()->getParams());

                $this->setStatus($share);

                $this->setImage($share);

                $this->setAttachedProducts($share);


                if(!$share->getId()) {
                    Mage::getSingleton('adminhtml/session')->addError('Cannot save the block');
                }

                $storeId = Mage::app()->getStore()->getId();
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect(
                        '*/*/edit',
                        array(
                            'id' => $share->getId(),
                            'store' => $storeId
                        )
                    );
                    return true;
                }

            } catch(Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBlockObject($share->getData());
                return  $this->_redirect('*/*/edit',array('id'=>$this->getRequest()->getParam('id')));
            }

            Mage::getSingleton('adminhtml/session')->addSuccess('Block was saved successfully!');

            $this->_redirect('*/*/'.$this->getRequest()->getParam('back','index'),array('id'=>$share->getId()));

            return $this;
        }

        private function setDates (&$share) {
            $share
                ->setCreateDatetime(
                    (new DateTime(
                        'now', new DateTimeZone('GMT')
                    ) )->format('Y-m-d H:i')
                )
                ->setStartDatetime(
                    (new DateTime(
                        $this->getRequest()->getParam('start_datetime'), new DateTimeZone('GMT')
                    ) )->format('Y-m-d H:i')
                )
                ->setEndDatetime(
                    (new DateTime(
                        $this->getRequest()->getParam('end_datetime'), new DateTimeZone('GMT')
                    ) )->format('Y-m-d H:i')
                )
                ->save();
        }

        private function setStatus (&$share) {
            $share
                ->setStatus(
                    Mage::helper(BARANIUK_SHARES::HELPER_ADMIN)->calculateShareStatus(
                        $this->getRequest()->getParam('start_datetime'),
                        $this->getRequest()->getParam('end_datetime')
                    )
                )
                ->save();

            return $this;
        }

        private function setImage (&$share) {
            $defautFileName = BARANIUK_SHARES::IMAGE_SHARE_DEFAULT;

            $is_delete = $this->getRequest()->getParam('image')['delete']
            and $share->getImage()['value'] != $defautFileName
            and $_FILES['image']['size'] != 0;

            if ($is_delete) {
                $this->deletePhoto($share->getImage()['value']);
            }

            if (!$is_delete && $loadedFileName = $this->_uploadFile( 'image' , $share))
            {
                $fileName = $loadedFileName;
            } else if (($is_delete) || (!$is_delete && $_FILES['image']['size'] == 0)) {
                $fileName = $defautFileName;
            } else{
                $fileName = $share->getImage()['value'];
            }

            $share
                ->setImage($fileName)
                ->save();

            return $this;
        }

        private function setAttachedProducts (&$share) {
            $links = $this->getRequest()->getParam('ids', null);

            if ($links === null) {
                return false;
            }

            $collection = Mage::getResourceModel(BARANIUK_SHARES::MODEL_PRODUCTS.'_collection')->addFieldToFilter('action_id', $share->getId());

            foreach ($collection as $item) {
                $item->delete();
            }

            if (!empty($links)) {
                $selectedProducts = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links);
                foreach($selectedProducts as $productId ) {
                    Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS)
                        ->setProductId($productId)
                        ->setActionId($share->getId())
                        ->save();
                }
            }

            return $this;
        }

        protected function _uploadFile($fieldName,$model) {

            if(empty($_FILES[$fieldName]['name'])) {
                return false;
            }

            $file = $_FILES[$fieldName];

            if(isset($file['name']) && (file_exists($file['tmp_name']))){
                if($model->getId()){
                    unlink(Mage::getBaseDir('media').DS.$model->getData($fieldName));
                }
                try
                {
                    $path = Mage::getBaseDir('media') . DS . BARANIUK_SHARES::MODULE . DS;
                    $uploader = new Varien_File_Uploader($file);
                    $uploader->setAllowedExtensions(array('jpg','png','gif','jpeg'));

                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);

                    $uploader->save($path, $file['name']);
                    $model->setData($fieldName,$uploader->getUploadedFileName());

                    return BARANIUK_SHARES::MODULE . DS. $uploader->getUploadedFileName();
                }
                catch(Exception $e)
                {
                    return false;
                }
            }

            return $this;
        }

        protected function deletePhoto ($image) {
            $photoPath = Mage::getBaseDir('media') . DS . $image;

            return unlink($photoPath);
        }

        public function productsAction() {
            $this->loadLayout();
            $this->renderLayout();

            return $this;
        }

        public function productsgridAction() {
            $this->loadLayout()
                ->renderLayout();

            return $this;
        }

    }