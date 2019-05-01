<?php

    class Baraniuk_IAI_Helper_Parser extends Mage_Core_Helper_Abstract
    {

        /**
         * @param $csvFile array Opened csv file
         *
         * @return object Contain array of the data $array and array of the attributes
         */
        public function csvFileToArray(array $csvFile)
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

            return
                /**
                 * @property array $array
                 * @property array $attributes
                 */
                new class ($formattedArray, $attributes)
                {

                    public $array;
                    public $attributes;

                    public function __construct(&$formattedArray, &$attributes)
                    {
                        $this->attributes = $attributes;
                        $this->array = $formattedArray;
                    }
                };
        }
    }
