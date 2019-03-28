<?php

    class Baraniuk_Shares_Block_Adminhtml_Shares_Grid extends Mage_Adminhtml_Block_Widget_Grid
    {

        public function __construct()
        {
            parent::__construct();
            $this->setId(BARANIUK_SHARES::ID_SHARES_GRID);
            $this->setDefaultSort('id');
            $this->setDefaultDir('ASC');

        }

        protected function _prepareCollection()
        {
            $collection = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->getCollection();
            /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
            $this->setCollection($collection);
            return parent::_prepareCollection();
        }

        protected function _prepareColumns()
        {
            /* @var $columns Baraniuk_Shares_Model_Block */
            $columns = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->getGridColumns();

            foreach ($columns as $column) {
                if ($column['active']) {
                    try {
                        switch ($column[ 'key' ]) {
                            default :
                                $this->addColumn( $column[ 'key' ] , array(
                                    'header' => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( $column[ 'name' ] ) ,
                                    'width' => $column[ 'width' ],
                                    'align' =>  $column[ 'align' ] ,
                                    'index' => $column[ 'key' ] ,
                                    'type' => $column[ 'type' ] ,
                                    'renderer' => $column[ 'renderer' ],
                                    'options' => $column[ 'options' ]
                                ) );
                                break;
                        }

                    } catch (Exception $e) {
                        echo "<script>alert('".$column["key"]." - error');</script>";
                    }
                }
            }


            return parent::_prepareColumns();
        }

        protected function _prepareMassaction()
        {
            $this->setMassactionIdField('id');
            $this->getMassactionBlock()->setIdFieldName('id');
            $this->getMassactionBlock()->setFormFieldName('ids');

            $this->getMassactionBlock()
                ->addItem('delete',
                          array(
                              'label' => Mage::helper(BARANIUK_SHARES::HELPER_HTML)->__('Delete'),
                              'url' => $this->getUrl('*/*/massDelete'),
                          )
                );

            return $this;
        }

        /**
         * Row click url
         *
         * @return string
         */
        public function getRowUrl($row)
        {
            return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }

    }