<?php

    class Baraniuk_IAI_Block_Adminhtml_Catalog_Product_Tab extends Mage_Adminhtml_Block_Template
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
    {

        /**
         * Retrieve the label used for the tab relating to this block
         *
         * @return string
         */
        public function getTabLabel ()
        {
            return $this->__( 'Auto imported images' );
        }

        /**
         * Retrieve the title used by this tab
         *
         * @return string
         */
        public function getTabTitle ()
        {
            return $this->__( 'Import of images' );
        }

        /**
         * Determines whether to display the tab
         * Add logic here to decide whether you want the tab to display
         *
         * @return bool
         */
        public function canShowTab ()
        {
            return true;
        }

        /**
         * Stops the tab being hidden
         *
         * @return bool
         */
        public function isHidden ()
        {
            return false;
        }

        public function getClass ()
        {
            return 'ajax';
        }

        public function getTabClass ()
        {
            return 'ajax';
        }

        public function getTabUrl ()
        {
            return $this->getUrl( '*/iai/grid' , array( '_current' => true ) );
        }


    }
