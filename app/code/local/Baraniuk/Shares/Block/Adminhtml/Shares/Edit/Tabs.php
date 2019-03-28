<?php

class Baraniuk_Shares_Block_Adminhtml_Shares_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('share_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper(BARANIUK_SHARES::HELPER_ADMIN)->__('Share id = '.$this->getRequest()->get('id')));
    }
    protected function _prepareLayout()
    {
        try {
            $this->addTab('main_tab', array(
                'label'     => $this->__('Main'),
                'title'     => $this->__('Main'),
                'content'   => $this->getLayout()->createBlock(BARANIUK_SHARES::ADMINHTML_BLOCK_EDIT_TABS_SHARES)->toHtml(),
            ));

            $this->addTab( 'products_tab' , BARANIUK_SHARES::ADMINHTML_BLOCK_EDIT_TABS_PRODUCTS);
        } catch (Exception $e) {
            trigger_error('Tabs creating error');
        }

        parent:: _prepareLayout();
    }
}