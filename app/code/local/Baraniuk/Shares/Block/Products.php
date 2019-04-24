<?php

    class Baraniuk_Shares_Block_Products extends Mage_Catalog_Block_Product_List {

        const COLUMN_ID = 'id';
        const COLUMN_SHARE_ID = 'action_id';
        const COLUMN_PRODUCT_ID = 'product_id';

        public $_productCollection;

        public function getCollection($shareId = null) {
            if (empty($shareId)) {
                $shareId = $this->getActiveId();
            }

            $shareProductCollection = Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS)->getCollection()
                ->addFieldToFilter('action_id', $shareId)
                ->getData();

            $storeId = Mage::app()->getStore()->getId();
            $productsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('*')
                ->addStoreFilter($storeId)
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->addFieldToFilter('entity_id', array('in' => $this->getProductsId($shareProductCollection)))
                ->addAttributeToSort('created_at', 'DESC');

            return $productsCollection;
        }

        public function getProductsId ($collection) {
            $ids = [];

            foreach ($collection as $item) {
                array_push($ids, $item[self::COLUMN_PRODUCT_ID]);
            }

            return count($ids) > 0 ? $ids : null;
        }

        public function getShare() {
            $_model = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES);
            /**@var $collection Baraniuk_Shares_Model_Resource_Block_Collection */
            $collection = $_model->load($this->getActiveId(), $_model::COLUMN_ID);

            return $collection;
        }

        public function getActiveId () {
            return $this->getRequest()->getParam('id');
        }

    }