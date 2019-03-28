<?php

    class Baraniuk_Shares_Model_Resource_Block extends Mage_Core_Model_Resource_Db_Abstract {

        public function _construct ()
        {
            $this->_init(BARANIUK_SHARES::MODEL_SHARES, 'id');
        }



    }