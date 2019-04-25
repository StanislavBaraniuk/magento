<?php

    class Baraniuk_IAI_Block_Renderer_Size extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
    {

        public function render ( Varien_Object $row )
        {
            $size = $row->getSize();

            return '<p>' . Mage::helper( 'baraniuk_iai/images' )->getFileSize( $size ) . '</p>';
        }

    }