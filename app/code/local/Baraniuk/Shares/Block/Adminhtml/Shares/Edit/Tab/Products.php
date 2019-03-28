<?php

    class Baraniuk_Shares_Block_Adminhtml_Shares_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Form
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
    {

        public function getTabLabel ()
        {
            return $this->__('Attached products');
        }

        public function getTabTitle ()
        {
            return $this->__('Attached products');
        }

        public function canShowTab ()
        {
            return true;
        }

        public function isHidden ()
        {
            return false;
        }

        public function getClass () {
            return 'ajax';
        }

        public function getTabClass () {
            return 'ajax';
        }

        public function getTabUrl () {
            return $this->getUrl('*/*/products', array('_current'=>true));
        }

    }