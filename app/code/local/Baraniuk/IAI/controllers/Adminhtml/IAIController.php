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

//            try {

//                $importModel->invalidateIndex();

//            } catch (Exception $e) {
//                return;
//            }


//            $data = $this->getRequest()->getPost();
//            try {
//                /** @var $import Mage_ImportExport_Model_Import */
//                $import = Mage::getModel('importexport/import');
//                $validationResult = $import->validateSource($import->setData("sku")->uploadSource());
//
//                if (!$import->getProcessedRowsCount()) {
//                    $this->addError($this->__('File does not contain data. Please upload another one'));
//                } else {
//                    if (!$validationResult) {
//                        if ($import->getProcessedRowsCount() == $import->getInvalidRowsCount()) {
//                            $this->addNotice(
//                                $this->__('File is totally invalid. Please fix errors and re-upload file')
//                            );
//                        } elseif ($import->getErrorsCount() >= $import->getErrorsLimit()) {
//                            $this->addNotice(
//                                $this->__('Errors limit (%d) reached. Please fix errors and re-upload file',
//                                    $import->getErrorsLimit())
//                            );
//                        } else {
//                            if ($import->isImportAllowed()) {
//                                $this->addNotice(
//                                    $this->__('Please fix errors and re-upload file or simply press "Import" button to skip rows with errors'),
//                                    true
//                                );
//                            } else {
//                                $this->addNotice(
//                                    $this->__('File is partially valid, but import is not possible'), false
//                                );
//                            }
//                        }
//                        // errors info
//                        foreach ($import->getErrors() as $errorCode => $rows) {
//                            $error = $errorCode . ' ' . $this->__('in rows:') . ' ' . implode(', ', $rows);
//                            $this->addError($error);
//                        }
//                    } else {
//                        if ($import->isImportAllowed()) {
//                            $this->addSuccess(
//                                $this->__('File is valid! To start import process press "Import" button'), true
//                            );
//                        } else {
//                            $this->addError(
//                                $this->__('File is valid, but import is not possible'), false
//                            );
//                        }
//                    }
//                    $this->addNotice($import->getNotices());
//                    $this->addNotice($this->__('Checked rows: %d, checked entities: %d, invalid rows: %d, total errors: %d',
//                        $import->getProcessedRowsCount(), $import->getProcessedEntitiesCount(),
//                        $import->getInvalidRowsCount(), $import->getErrorsCount()));
//                }
//            } catch (Exception $e) {
//                $this->addNotice($this->__('Please fix errors and re-upload file'))
//                    ->addError($e->getMessage());
//            }


//            /** @var Baraniuk_IAI_Helper_Parser $parserHelper */
//                        $parserHelper = Mage::helper('baraniuk_iai/parser');
//
//                        /** @var Baraniuk_IAI_Helper_Attributes $attributesHelper */
//                        $attributesHelper = Mage::helper('baraniuk_iai/attributes');
//
//                        if ($_FILES[ 'fileImport' ]['type'] == "text/csv") {
//                            $csvFile = file($_FILES[ 'fileImport' ][ 'tmp_name' ]);
//                        } else {
//                            $this->_redirectWithError("Current file is not CSV file");
//                            return false;
//                        }
//
//                        try {
//                            /** @var $dataObject Baraniuk_IAI_Model_Image_Import_CsvArrayKeeper * */
//                            $dataObject = $parserHelper->csvFileToArray($csvFile);
//                        } catch (Exception $e) {
//                            $this->_redirectWithError("Can not to parse a file");
//                            return false;
//                        }
//
//                        try {
//                            /** @var $attributesExist Baraniuk_IAI_Model_Image_Attributes_AttributesExist */
//                            $attributesExist = $attributesHelper->attributesExist($dataObject->attributes, array("sku", "url"), true);
//                        } catch (Exception $e) {
//                            $this->_redirectWithError("Can not to check the required attributes");
//                            return false;
//                        }
//
//                        if (!$attributesExist->_status) {
//
//                            Mage::getSingleton('core/session')->addError($attributesExist->_message);
//                        } else {
//
//                            foreach ($dataObject->array as $item) {
//
//                                /** @var Baraniuk_IAI_Model_Image $iaiModel */
//                                $iaiModel = Mage::getModel("baraniuk_iai/image");
//                                $iaiModel
//                                    ->setSku($item[ 'sku' ])
//                                    ->setUrl($item[ 'url' ])
//                                    ->setStatus($iaiModel->STATUS_QUEUE)
//                                    ->setCreateAt(
//                                        (new DateTime('now', new DateTimeZone('GMT')))->format('Y-m-d H:i')
//                                    )
//                                    ->save();
//                            }
//
//                            Mage::getSingleton('core/session')->addSuccess($attributesExist->_message);
//
//                        }
//
            $this->_redirectUrl($_SERVER[ "HTTP_REFERER" ]);
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
