<?php

    class Baraniuk_Shares_Block_Adminhtml_Shares_Edit_Tab_Products_Grid extends Mage_Adminhtml_Block_Widget_Grid
    {

        protected $_share;

        public function __construct()
        {

            parent::__construct();
            $this->setId('baraniuk_shares_product_grid');
            $this->setDefaultSort('entity_id');
            $this->setUseAjax(true);
            $this->_getShare();

        }

        protected function _getShare()
        {

            if (!$this->_share) {
                $this->_share = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->load(
                    $this->getRequest()->getParam('id')
                );
            }

            return $this->_share;

        }

        protected function _addColumnFilterToCollection($column)
        {

            if ($column->getId() == 'in_products') {
                $productIds = $this->_getSelectedProducts();
                if (empty($productIds)) {
                    $productIds = 0;
                }
                if ($column->getFilter()->getValue()) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
                } else {
                    if($productIds) {
                        $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                    }
                }
            } else {
                parent::_addColumnFilterToCollection($column);
            }
            return $this;

        }

        /**
         * Prepare collection
         *
         * @return Mage_Adminhtml_Block_Widget_Grid
         */
        protected function _prepareCollection()
        {
            $collection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*');

            $this->setCollection($collection);
            return parent::_prepareCollection();

        }

        /**
         * Add columns to grid
         *
         * @return Mage_Adminhtml_Block_Widget_Grid
         */
        protected function _prepareColumns()
        {

            $this->addColumn('in_products', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'ids',
                'values'    => $this->_getSelectedProducts(),
                'align'     => 'center',
                'index'     => 'entity_id'
            ));


            $this->addColumn('entity_id', array(
                'header'    => Mage::helper('catalog')->__('ID'),
                'sortable'  => true,
                'width'     => 60,
                'index'     => 'entity_id'
            ));
            $this->addColumn('name_p', array(
                'header'    => Mage::helper('catalog')->__('Name'),
                'index'     => 'name'
            ));

            $this->addColumn('type', array(
                'header'    => Mage::helper('catalog')->__('Type'),
                'width'     => 100,
                'index'     => 'type_id',
                'type'      => 'options',
                'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));

            $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
                ->load()
                ->toOptionHash();


            $this->addColumn('status', array(
                'header'    => Mage::helper('catalog')->__('Status'),
                'width'     => 90,
                'index'     => 'status',
                'type'      => 'options',
                'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
            ));

            $this->addColumn('visibility', array(
                'header'    => Mage::helper('catalog')->__('Visibility'),
                'width'     => 90,
                'index'     => 'visibility',
                'type'      => 'options',
                'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
            ));

            $this->addColumn('sku', array(
                'header'    => Mage::helper('catalog')->__('SKU'),
                'width'     => 80,
                'index'     => 'sku'
            ));

            return parent::_prepareColumns();

        }

        /**
         * Rerieve grid URL
         *
         * @return string
         */
        public function getGridUrl()
        {
            return $this->getUrl('*/*/productsgrid', array('_current'=>true));
        }

        /**
         * Retrieve selected upsell products
         *
         * @return array
         */
        protected function _getSelectedProducts()
        {

            $shareId = $this->_share->getId();

            $shareProductCollection = Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS)->getCollection()
                ->addFieldToFilter('action_id', $shareId)
                ->getData();

            $productsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter('entity_id', $this->getProductsId($shareProductCollection, 'product_id'))
                ->addAttributeToSort('created_at', 'DESC');

            if (!empty($links = $this->getRequest()->getPost('ids', null))) {
                return $links;
            }


            return $this->getProductsId($productsCollection->getData(), 'entity_id');

        }

        /**
         * Retrieve upsell products
         *
         * @return array array(int id, ... , int id)
         * @throws Mage_Core_Exception
         */
        public function getSelectedShareProducts()
        {

            $shareId = $this->_share->getId();

            $shareProductCollection = Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS)->getCollection()
                ->addFieldToFilter('action_id', $shareId)
                ->getData();

            $productsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter('entity_id', $this->getProductsId($shareProductCollection, 'product_id'))
                ->addAttributeToSort('created_at', 'DESC');

            $products = array();

            foreach ($productsCollection as $product) {
                $products[] = $product->getId();
            }

            return $products;

        }

        /**
         * @param $collection
         * @param $idColumn
         *
         * @return array|null array(int id, ... , int id)
         */
        public function getProductsId ($collection, $idColumn) {
            $ids = [];

            foreach ($collection as $item) {
                array_push($ids, $item[$idColumn]);
            }

            return count($ids) > 0 ? $ids : null;
        }

    }
