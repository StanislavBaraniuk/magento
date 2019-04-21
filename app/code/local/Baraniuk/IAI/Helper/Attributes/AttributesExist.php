<?php

    class Baraniuk_IAI_Helper_Attributes_AttributesExist {

        /** @var bool $_status File compliance to requires */
        public $_status;

        /** @var string $_status Message for output */
        public $_message;

        public function __construct ($incorrectAttributes)
        {
            $this->_status = empty($incorrectAttributes);

            if (!$this->_status) {
                $this->_message = Mage::helper('baraniuk_iai/helper')->__("Undefined attributes") . ": ";
                foreach ($incorrectAttributes as $key => $attribute) {
                    if ($key == count($incorrectAttributes)-1) {
                        $this->_message .= '`' . $attribute . '`';
                    } else {
                        $this->_message .= '`' . $attribute . '`,';
                    }
                }
            } else {
                $this->_message = Mage::helper('baraniuk_iai/helper')->__('File imported success');
            }
        }
    }