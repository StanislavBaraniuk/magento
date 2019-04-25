<?php

    class Baraniuk_IAI_Block_Adminhtml_IAI_Import extends Mage_Adminhtml_Block_Widget_Form_Container
    {

        protected $_blockGroup = "baraniuk_iai";
        protected $_controller = "adminhtml_iai";

        public function __construct ()
        {
            parent::__construct();
            $this->_removeButton( 'back' );
            $this->_removeButton( 'save' );

            $this->_addButton( 'back' , array(
                'label' => Mage::helper( 'baraniuk_iai/data' )->__( 'Back' ) ,
                'onclick' => 'back()' ,
                'class' => 'back'
            ) , 1 );

            $this->_addButton( 'save' , array(
                'label' => Mage::helper( 'baraniuk_iai/data' )->__( 'Import' ) ,
                'onclick' => 'importFile()' ,
                'class' => 'save'
            ) , -2 );

            $this->_formScripts[] = "
             function importFile(){
  
                editForm.submit($('edit_form').action + 'adminhtml/iai/import/');
             }";
            $this->_formScripts[] = "
             function back(){
                window.location.href = \"" . $_SERVER[ 'HTTP_REFERER' ] . "\";
             }
             ";

            $this->_headerText = Mage::helper( 'baraniuk_iai/data' )->__( 'Import of images' );
        }

        public function getHello ()
        {
            return 'hello';
        }

    }