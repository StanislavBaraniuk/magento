<?php

    class Baraniuk_Shares_Block_Adminhtml_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
    {

        public function render(Varien_Object $row)
        {
            $image = $row->getData()['image'];

            if (!filter_var($image, FILTER_VALIDATE_URL)) {
                $image = explode('index.php/',Mage::getBaseUrl())[0].'media/'.$image;
            }

            $dimensions = 'width:50px; height:50px;';
            $backPosition = 'background-position:center;';
            $backSize = 'background-size:cover;';
            $backRepeat = 'background-repeat:no-repeat;';

            return '<img style="'.$dimensions.$backPosition.$backRepeat.$backSize.'" src="'.$image.'" />';
        }

    }