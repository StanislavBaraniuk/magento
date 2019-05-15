<?php

    class Baraniuk_IAI_Model_Import {

        const VALIDATION_SIMILAR_ROWS = true;

        /**
         * @var $_parser Baraniuk_IAI_Model_Import_Parser
         */
        private $_parser = null;

        /**
         * @var $_data Baraniuk_IAI_Model_Import_Parser_Entity_CsvArrayKeeper
         */
        private $_data = null;

        /**
         * @var $requiredAttributes array
         */
        private $_requiredAttributes = array("sku", "url");

        /**
         * @var array
         */
        private $_file = null;

        /**
         * @var Baraniuk_IAI_Model_Image $_model
         */
        private $_model = null;

        /**
         * Baraniuk_IAI_Model_Import constructor.
         */
        public function __construct()
        {
            $this->_parser = Mage::getModel("baraniuk_iai/import_parser");
            $this->_model =  Mage::getModel("baraniuk_iai/image");
        }

        /**
         * @return bool|null
         */
        public function import (): ?bool {

            if ($this->_openFile()) {

                $this->_data = $this->_parser->csvFileToArray($this->_file);

                if ($this->checkRequiredAttributesExisting()) {

                    $this->_save();
                }
            }

            return null;
        }

        /**
         * @return bool
         */
        private function checkRequiredAttributesExisting (): bool {

            $isExist = true;

            foreach ($this->_requiredAttributes as $requiredAttribute) {
                if (!in_array($requiredAttribute, $this->_data->attributes)) {
                    $this->_addError("The required attribute `$requiredAttribute` is undefined in file");
                    $isExist = false;
                }
            }

            return $isExist;
        }

        private function _checkDidRowContainAllRequiredAttributes ($row): bool {

            $isExist = true;

            foreach ($this->_requiredAttributes as $requiredAttribute) {
                if (!isset($row[$requiredAttribute])) {
                    $isExist = false;
                }
            }

            return $isExist;
        }

        /**
         * @return bool
         */
        private function _openFile (): bool {

            $file = file($_FILES[ 'fileImport' ][ 'tmp_name' ]);

            if ($file) {
                if ($_FILES[ 'fileImport' ]['type'] == "text/csv") {

                    $this->_file = $file;

                    return true;
                } else {
                    $this->_addError("Current file is not CSV file");
                }
            } else {
                $this->_addError("File is undefined");
            }

            return false;
        }

        /**
         * @return array
         */
        public function getErrors(): array {
            return $this->_parser->errors;
        }

        /**
         * @param $error
         *
         * @return Baraniuk_IAI_Model_Import
         */
        private function _addError($error): self {
            array_push($this->_parser->errors, $error);
            return $this;
        }

        private function _save() {
            foreach ($this->_data->array as $key => $item) {

                if (!$this->_checkDidRowContainAllRequiredAttributes($item)) {
                    unset($this->_data->array[$key]);
                    continue;
                }

                $isExist = self::VALIDATION_SIMILAR_ROWS ? $this->_checkSimilarRows($item) : false;

                /** @var Baraniuk_IAI_Model_Image $model */
                $model = Mage::getModel("baraniuk_iai/image");

                if (!$isExist) {
                    $model
                        ->setSku($item[ 'sku' ])
                        ->setUrl($item[ 'url' ])
                        ->setStatus($this->_model->STATUS_QUEUE)
                        ->setCreateAt(
                            (new DateTime('now', new DateTimeZone('GMT')))->format('Y-m-d H:i')
                        )
                        ->save();
                } else {
                    unset($this->_data->array[$key]);
                    $this->_addError("Row " . $key . " already exist");
                }
            }
        }

        private function _checkSimilarRows($row): bool {

            $similarRows = $this->_model->getCollection()
                ->addFieldToFilter("sku", array("eq" => $row[ 'sku' ]));

            $isExist = false;

            foreach ($similarRows->getData() as $datum) {
                if (array_search($row[ 'url' ], $datum)) {
                    $isExist = true;
                    break;
                }
            }

            return $isExist;
        }

        public function getParsedArray(): array {
            return $this->_data->array;
        }
    }
