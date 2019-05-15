<?php

    class Baraniuk_IAI_Model_Import_Parser
    {

        /**
         * @var $_validator Baraniuk_IAI_Model_Import_Parser_Validator
         */
        private $_validator = null;

        public $errors = [];

        public function __construct()
        {
            $this->_validator = Mage::getModel("baraniuk_iai/import_parser_validator");
        }


        /**
         * @param $csvFile array Opened csv file
         *
         * @return Baraniuk_IAI_Model_Import_Parser_Entity_CsvArrayKeeper
         */
        public function csvFileToArray(array $csvFile): Baraniuk_IAI_Model_Import_Parser_Entity_CsvArrayKeeper
        {

            $parsedCsv = $this->parse($csvFile);

            $attributes = $this->getAttributesFromParsedCSVData($parsedCsv);
            $this->deleteAttributesFromParsedCSVData($parsedCsv);

            $formattedArray = array();

            foreach ($parsedCsv as $key => $datum) {
                foreach ($attributes as $keyA => $attribute) {

                    $validation = $this->_validator->validate(array($attribute => $datum[ $keyA ]));

                    if ($validation) {
                        $formattedArray[ $key ][ $attribute ] = $datum[ $keyA ];
                    } else {
                        if ($validation !== null) {
                            $this->errors[] = "Value of `$attribute` is incorrect in row: " . ($key);
                        }
                    }
                }
            }

            return new Baraniuk_IAI_Model_Import_Parser_Entity_CsvArrayKeeper($formattedArray, $attributes);
        }

        /**
         * Get or Set validator will using
         *
         * @param Baraniuk_IAI_Model_Import_Parser_Validator|null $validator
         *
         * @return Baraniuk_IAI_Model_Import_Parser_Validator|null
         */
        public function validator(?Baraniuk_IAI_Model_Import_Parser_Validator $validator = null
        ): ?Baraniuk_IAI_Model_Import_Parser_Validator {

            if ($validator === null) {

                return $this->_validator;
            } else {

                $this->_validator = $validator;
                return null;
            }
        }

        /**
         * Get attributes from parsed csv data and delete it from
         *
         * @param array $array
         *
         * @return array
         */
        private function getAttributesFromParsedCSVData(array $array): array
        {

            return $array[ 0 ];
        }

        /**
         * @param array $array
         */
        private function deleteAttributesFromParsedCSVData(array & $array)
        {
            unset($array[ 0 ]);
        }

        /**
         * @param array $csvFile
         *
         * @return array|null
         */
        private function parse(array $csvFile): ?array
        {
            foreach ($csvFile as $line) {
                $data[] = str_getcsv($line);
            }

            return $data ? $data : null;
        }
    }
