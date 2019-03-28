<?php

class Baraniuk_Shares_Block_Adminhtml_Shares_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_blockGroup = BARANIUK_SHARES::MODULE;
    protected $_controller = BARANIUK_SHARES::CONTROLLER_ADMINHTML;

    /**
     * Block constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save'
        ), -100);

        $this->_formScripts[] = "
             function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
             }
             ";

        $this->_headerText = 'Set up your Share';
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id')));
    }

    protected function _getModel()
    {
        $model = Mage::registry('baraniuk_shares');

        return $model;
    }
}




