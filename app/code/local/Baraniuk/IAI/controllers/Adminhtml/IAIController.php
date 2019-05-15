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

        /**
         * Send error message to session
         *
         * @param mixed ...$error
         *
         * @return Baraniuk_IAI_Adminhtml_IAIController
         */
        private function _addError(...$error): self
        {
            $this->_getCoreSessionSingleton()->addError(...$error);
            return $this;
        }

        /**
         * Send success message to session
         *
         * @param mixed ...$success
         *
         * @return Baraniuk_IAI_Adminhtml_IAIController
         */
        private function _addSuccess(...$success): self
        {
            $this->_getCoreSessionSingleton()->addSuccess(...$success);
            return $this;
        }

        /**
         * Get object of session
         *
         * @return Mage_Core_Model_Session
         */
        private function _getCoreSessionSingleton(): Mage_Core_Model_Session
        {
            /** @var $coreSessionSingleton Mage_Core_Model_Session * */
            $coreSessionSingleton = Mage::getSingleton('core/session');
            return $coreSessionSingleton;
        }
    }
