<?php

class Baraniuk_Shares_Block_Adminhtml_Shares extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_blockGroup = 'baraniuk_shares';
    protected $_controller = 'adminhtml_shares';

    protected function _construct()
    {
        parent::_construct();
        $helper = Mage::helper(BARANIUK_SHARES::HELPER_ADMIN);
    }
}