<?php

    class Baraniuk_IAI_Model_Resource_Image extends Mage_Core_Model_Resource_Db_Abstract
    {

        public function _construct()
        {
            $this->_init("baraniuk_iai/image", 'id');
        }

    }
