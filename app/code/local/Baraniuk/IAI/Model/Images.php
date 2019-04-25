<?php

    class Baraniuk_IAI_Model_Images extends Mage_Core_Model_Abstract
    {

        /*
         * Default column names
         */
        const COLUMN_ID = 'id';
        const COLUMN_IMAGE_URL = 'ur';
        const COLUMN_PRODUCT_SKU = 'sku';
        const COLUMN_CREATE_DATETIME = 'create_at';
        const COLUMN_LOAD_DATETIME = 'load_at';
        const COLUMN_IMAGE_SIZE = 'size';
        const COLUMN_LOAD_STATUS = 'status';
        const COLUMN_LOAD_ERROR_TEXT = 'is_active';


        /** @var int If a row is in queue */
        const STATUS_QUEUE = 0;

        /** @var  int If a row loaded already */
        const STATUS_LOADED = 2;

        /** @var int If load trying has an error */
        const STATUS_ERROR = 4;

        /** @var int If load trying has a 404 error */
        const STATUS_RETRY = 1;

        public function _construct ()
        {
            parent::_construct();
            $this->_init( "baraniuk_iai/images" );

        }

    }
