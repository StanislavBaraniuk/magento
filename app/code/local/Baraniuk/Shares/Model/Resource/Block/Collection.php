<?php

    class Baraniuk_Shares_Model_Resource_Block_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

        public function _construct ()
        {
            parent::_construct();
            $this->_init(BARANIUK_SHARES::MODEL_SHARES);
        }

    }