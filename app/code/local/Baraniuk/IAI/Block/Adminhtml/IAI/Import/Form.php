<?php

    class Baraniuk_IAI_Block_Adminhtml_IAI_Import_Form extends Mage_Adminhtml_Block_Widget_Form
    {
        protected function _prepareForm()
        {

            $form = new Varien_Data_Form(
                array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/import'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                )
            );

            $fieldset = $form->addFieldset(
                'main_tab',
                array(
                    'legend' => Mage::helper("baraniuk_iai/data")->__('Waiting for file'),
                    'class' => 'fieldset-wide'
                ));


            $fieldset->addField('file', 'file', array(
                'name' => 'fileImport" accept=".csv',
                'label' => Mage::helper("baraniuk_iai/data")->__("Import"),
                'title' => Mage::helper("baraniuk_iai/data")->__("Import"),
                'required' => true,
            ));

            $form->setUseContainer(true);
            $this->setForm($form);

            return parent::_prepareForm();
        }

        public function getTabLabel()
        {
            return $this->__('Import of images');
        }

        public function getTabTitle()
        {
            return $this->__('Import of images');
        }

        public function canShowTab()
        {
            return true;
        }

        public function isHidden()
        {
            return false;
        }

    }
