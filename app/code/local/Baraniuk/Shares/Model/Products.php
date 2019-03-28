<?php

    class Baraniuk_Shares_Model_Products extends Mage_Core_Model_Abstract {

        protected static $_gridColumns = null;

        public function _construct ()
        {
            parent::_construct();
            $this->_init(BARANIUK_SHARES::RESOURCE_PRODUCTS);

            self::$_gridColumns = [
                [
                    'active' => true,
                    'key' => 'id',
                    'name' => 'ID',
                    'type' => 'int',
                    'width' => '100',
                    "align" => 'center',
                    'renderer' => '',
                    'options' => '',
                    'readable' => false,
                    'input' => '',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'action_id',
                    'name' => 'Share id',
                    'type' => 'int',
                    'width' => '100',
                    "align" => 'center',
                    'renderer' => '',
                    'options' => '',
                    'readable' => false,
                    'input' => 'text',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'product_id',
                    'name' => 'Product id',
                    'type' => 'int',
                    'width' => '100',
                    "align" => 'center',
                    'renderer' => '',
                    'options' => '',
                    'readable' => true,
                    'input' => 'text',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ]
            ];
        }


        public function getGridColumns () {
            return self::$_gridColumns;
        }


    }