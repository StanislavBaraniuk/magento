<?php

    class Baraniuk_IAI_Adminhtml_IAIController extends Mage_Adminhtml_Controller_Action
    {

        public function indexAction()
        {
            $this->loadLayout();
            $this->renderLayout();
        }

        public function importAction()
        {

            /** @var Baraniuk_IAI_Helper_Parser $parserHelper */
            $parserHelper = Mage::helper('baraniuk_iai/parser');

            /** @var Baraniuk_IAI_Helper_Attributes $attributesHelper */
            $attributesHelper = Mage::helper('baraniuk_iai/attributes');

//            $mem_start = memory_get_usage();

            $csvFile = file($_FILES[ 'fileImport' ][ 'tmp_name' ]);

            $dataObject = $parserHelper->csvFileToArray($csvFile);

            $attributesExist = $attributesHelper->attributesExist($dataObject->attributes, array("sku", "url"), true);

            if (!$attributesExist->_status) {

                Mage::getSingleton('core/session')->addError($attributesExist->_message);
            } else {

                foreach ($dataObject->array as $item) {

                    /** @var Baraniuk_IAI_Model_Image $iaiModel */
                    $iaiModel = Mage::getModel("baraniuk_iai/image");
                    $iaiModel
                        ->setSku($item[ 'sku' ])
                        ->setUrl($item[ 'url' ])
                        ->setStatus($iaiModel->STATUS_QUEUE)
                        ->setCreateAt(
                            (new DateTime('now', new DateTimeZone('GMT')))->format('Y-m-d H:i')
                        )
                        ->save();
                }

                Mage::getSingleton('core/session')->addSuccess($attributesExist->_message);

            }

            $this->_redirectUrl($_SERVER[ "HTTP_REFERER" ]);

//            $end = memory_get_usage() - $mem_start;
        }


        public function gridAction()
        {
            $this->loadLayout();
            $this->getResponse()->setBody(
                $this->getLayout()->createBlock('baraniuk_iai/adminhtml_catalog_product_tab_grid')->toHtml()
            );

            return $this;
        }
    }
