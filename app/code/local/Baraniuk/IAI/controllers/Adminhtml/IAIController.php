<?php

    class Baraniuk_IAI_Adminhtml_IAIController extends Mage_Adminhtml_Controller_Action
    {

        public function indexAction()
        {
            $this->loadLayout();
            $this->renderLayout();
        }

        public function importAction()
        {
            $d = 1;
            /** @var Baraniuk_IAI_Model_Import $importer */
            $importer = Mage::getModel('baraniuk_iai/import');

            $importer->import();

            foreach ($importer->getErrors() as $error) {
                $this->_addError($error);
            }

            $countOfSavedElements = count($importer->getParsedArray());

            if ($countOfSavedElements > 0) {
                $this->_addSuccess("$countOfSavedElements row(s) saved.");
            }

            $this->_redirectReferer();
        }


        public function gridAction()
        {
            $this->loadLayout();
            $this->getResponse()->setBody(
                $this->getLayout()->createBlock('baraniuk_iai/adminhtml_catalog_product_tab_grid')->toHtml()
            );
        }

        private function _addError(...$error): Baraniuk_IAI_Adminhtml_IAIController
        {
            $this->_getCoreSessionSingleton()->addError(...$error);
            return $this;
        }

        private function _addNotice(...$notice): Baraniuk_IAI_Adminhtml_IAIController
        {
            $this->_getCoreSessionSingleton()->addNotice(...$notice);
            return $this;
        }

        private function _addSuccess(...$success): Baraniuk_IAI_Adminhtml_IAIController
        {
            $this->_getCoreSessionSingleton()->addSuccess(...$success);
            return $this;
        }

        private function _getCoreSessionSingleton(): Mage_Core_Model_Session
        {
            /** @var $coreSessionSingleton Mage_Core_Model_Session * */
            $coreSessionSingleton = Mage::getSingleton('core/session');
            return $coreSessionSingleton;
        }
    }
