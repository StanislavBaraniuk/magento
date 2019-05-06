<?php

    class Baraniuk_IAI_Helper_Parser extends Mage_Core_Helper_Abstract
    {

        /**
         * @param $csvFile array Opened csv file
         *
         * @return Baraniuk_IAI_Model_Image_Import_CsvArrayKeeper
         */
        public function csvFileToArray(array $csvFile): Baraniuk_IAI_Model_Image_Import_CsvArrayKeeper
        {

            $formattedArray = [];

            foreach ($csvFile as $line) {
                $data[] = str_getcsv($line);
            }

            $attributes = $data[ 0 ];
            unset($data[ 0 ]);

            foreach ($data as $key => $datum) {
                foreach ($attributes as $keyA => $attribute) {

                    $formattedArray[ $key ][ $attribute ] = $datum[ $keyA ];
                }
            }

            return new Baraniuk_IAI_Model_Image_Import_CsvArrayKeeper($formattedArray, $attributes);
        }
    }
