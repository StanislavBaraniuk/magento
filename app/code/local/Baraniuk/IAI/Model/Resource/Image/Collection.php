<?php

    class Baraniuk_IAI_Model_Resource_Image_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {

        public function _construct()
        {
            parent::_construct();
            $this->_init("baraniuk_iai/image");
        }

    }
