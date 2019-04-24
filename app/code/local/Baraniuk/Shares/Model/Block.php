<?php

    class Baraniuk_Shares_Model_Block extends Mage_Core_Model_Abstract {

        /*
         * Default column names
         */
        const COLUMN_START_DATE = 'start_datetime';
        const COLUMN_END_DATE = 'end_datetime';
        const COLUMN_TITLE = 'name';
        const COLUMN_DESCRIPTION = 'description';
        const COLUMN_IMAGE = 'image';
        const COLUMN_ID = 'id';
        const COLUMN_SHORT_DESCRIPTION = 'short_description';
        const COLUMN_STATUS = 'status';
        const COLUMN_ACTIVE = 'is_active';


        /** @var int Use if current date less than start date */
        const STATUS_WAIT = 1;

        /** @var int Use if current date greater or equal than start date */
        const STATUS_OPEN = 2;

        /** @var int Use if current date greater or equal than end date */
        const STATUS_CLOSE = 3;

        const ENABLE = 1;
        const DISABLE = 0;

        protected static $_gridColumns = null;

        public function _construct ()
        {
            parent::_construct();
            $this->_init(BARANIUK_SHARES::MODEL_SHARES);

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
                    'key' => 'status',
                    'name' => 'STATUS',
                    'type' => 'options',
                    'width' => '50',
                    "align" => 'center',
                    'renderer' => '',
                    'options' => array(1 => 'In waiting', 2 => 'Active', 3 => 'End'),
                    'readable' => false,
                    'readonly' => false,
                    'input' => 'select',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'is_active',
                    'name' => 'IS ACTIVE',
                    'type' => 'options',
                    'width' => '50',
                    "align" => 'center',
                    'renderer' => '',
                    'options' => array(1 => 'Enable', 0 => 'Disable'),
                    'readable' => true,
                    'input' => 'select',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'name',
                    'name' => 'NAME',
                    'type' => 'text',
                    'width' => '',
                    "align" => 'left',
                    'renderer' => '',
                    'options' => '',
                    'readable' => true,
                    'input' => 'text',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => false,
                    'key' => 'description',
                    'name' => 'DESCRIPTION',
                    'type' => 'text',
                    'width' => '',
                    "align" => 'left',
                    'renderer' => '',
                    'options' => '',
                    'readable' => true,
                    'input' => 'textarea',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'short_description',
                    'name' => 'SHORT DESCRIPTION',
                    'type' => 'text',
                    'width' => '',
                    "align" => 'left',
                    'renderer' => '',
                    'options' => '',
                    'readable' => true,
                    'input' => 'textarea',
                    'format' => '',
                    'image' => '',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'image',
                    'name' => 'IMAGE',
                    'type' => 'image',
                    'width' => '50',
                    "align" => 'left',
                    'renderer' => BARANIUK_SHARES::MODULE.'_'.BARANIUK_SHARES::RENDERER_IMAGE,
                    'options' => '',
                    'readable' => true,
                    'input' => 'image',
                    'format' => '',
                    'image' => '',
                    'required' => false
                ],
                [
                    'active' => false,
                    'key' => 'created_at',
                    'name' => 'CREATED',
                    'type' => 'datetime',
                    'width' => '150',
                    "align" => 'left',
                    'renderer' => '',
                    'options' => '',
                    'readable' => false,
                    'input' => 'date',
                    'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                    'image' => 'images/grid-cal.gif',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'start_datetime',
                    'name' => 'START',
                    'type' => 'datetime',
                    'width' => '150',
                    "align" => 'left',
                    'renderer' => '',
                    'options' => '',
                    'readable' => true,
                    'input' => 'date',
                    'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                    'image' => 'images/grid-cal.gif',
                    'required' => true
                ],
                [
                    'active' => true,
                    'key' => 'end_datetime',
                    'name' => 'END',
                    'type' => 'datetime',
                    'width' => '150',
                    "align" => 'left',
                    'renderer' => '',
                    'options' => '',
                    'readable' => true,
                    'input' => 'date',
                    'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                    'image' => 'images/grid-cal.gif',
                    'required' => false
                ]
            ];
        }


        public function getGridColumns () {
            return self::$_gridColumns;
        }

    }