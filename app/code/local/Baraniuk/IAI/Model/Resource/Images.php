<?php

    class Baraniuk_IAI_Model_Resource_Images extends Mage_Core_Model_Resource_Db_Abstract
    {

        public function _construct()
        {
            $this->_init("baraniuk_iai/images", 'id');
        }

    }
