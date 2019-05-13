<?php

    class Baraniuk_IAI_Block_Adminhtml_Catalog_Product_Tab_Grid extends Mage_Adminhtml_Block_Widget_Grid
    {
        public function __construct()
        {
            parent::__construct();
            $this->setId('baraniuk_iai_grid');
            $this->setDefaultSort('id');
            $this->setDefaultDir('ASC');
            $this->setSaveParametersInSession(true);
            $this->setUseAjax(true);
        }

        protected function _prepareCollection()
        {
            $sku = Mage::getResourceModel("catalog/product")->getProductsSku(
                        array($this->getRequest()->getParam('id'))
                    )[ 0 ][ "sku" ];

            /** @var \Baraniuk_IAI_Model_Resource_Image_Collection * */
            $collection = Mage::getModel('baraniuk_iai/image')->getCollection()
                ->addFieldToFilter('sku', $sku);

            $this->setCollection($collection);
            return parent::_prepareCollection();
        }

        protected function _prepareColumns()
        {

            /**@var $iaiModel Baraniuk_IAI_Model_Image int * */
            $iaiModel = Mage::getModel('baraniuk_iai/image');

            $this->addColumn('id', array(
                'header' => Mage::helper('baraniuk_iai')->__('ID'),
                'align' => 'center',
                'width' => '50px',
                'index' => 'id',
            ));

            $this->addColumn('create_at', array(
                'header' => Mage::helper('baraniuk_iai')->__('Create date'),
                'align' => 'center',
                'type' => 'date',
                'index' => 'create_at',
            ));

            $this->addColumn('load_at', array(
                'header' => Mage::helper('baraniuk_iai')->__('Load date'),
                'align' => 'center',
                'type' => 'date',
                'index' => 'load_at',
                'default' => Mage::helper('baraniuk_iai')->__("Awaits")
            ));

            $this->addColumn('url', array(
                'header' => Mage::helper('baraniuk_iai')->__('Image url'),
                'align' => 'left',
                'index' => 'url',
            ));

            $this->addColumn('size', array(
                'header' => Mage::helper('baraniuk_iai')->__('Image size'),
                'align' => 'left',
                'index' => 'size',
                'default' => 0,
                'renderer' => 'Baraniuk_IAI_Block_Renderer_Size'
            ));

            $this->addColumn('status', array(

                'header' => Mage::helper('baraniuk_iai')->__('Status of loading'),
                'align' => 'center',
                'width' => '80px',
                'index' => 'status',
                'type' => 'options',
                'options' => array(
                    $iaiModel::STATUS_QUEUE => Mage::helper('baraniuk_iai')->__('Queue'),
                    $iaiModel::STATUS_LOADED => Mage::helper('baraniuk_iai')->__('Loaded'),
                    $iaiModel::STATUS_ERROR => Mage::helper('baraniuk_iai')->__('Error'),
                    $iaiModel::STATUS_RETRY => Mage::helper('baraniuk_iai')->__('Retry')
                ),
            ));

            $this->addColumn('error_text', array(
                'header' => Mage::helper('baraniuk_iai')->__('Error'),
                'align' => 'left',
                'index' => 'error_text',
                'default' => Mage::helper('baraniuk_iai')->__('Nothing errors')
            ));


            return parent::_prepareColumns();
        }

        public function getGridUrl()
        {
            return $this->getUrl('*/iai/grid', array('_current' => true));
        }
    }
