<?php

    class Baraniuk_IAI_Helper_Parser extends Mage_Core_Helper_Abstract
    {

        public function getCsvAttributes ( array $csvArray ): array
        {
            $keys = array();
            foreach ($csvArray as $key => $item) {

                $explodeBy = '';

                if (strpos( $item , "\t" )) {
                    $explodeBy .= "\t";
                }

                if (strpos( $item , "\r" )) {
                    $explodeBy .= "\r";
                }

                if (strpos( $item , "\n" )) {
                    $explodeBy .= "\n";
                }

                if (empty( $explodeBy )) {
                    array_push( $keys , $item );
                } else {
                    $explodedRow = explode( $explodeBy , $item )[ 0 ];
                    array_push( $keys , explode( $explodeBy , $item )[ 0 ] );
                    break;
                }
            }

            return $keys;
        }


        /**
         * @param array $csvArray CSV data without formatting
         * @param array|null $keys
         *
         * @return array
         */
        public function csvToArray ( array $csvArray , array $attributes = null ): array
        {
            $attributes = $attributes === null ? $this->getCsvAttributes( $csvArray ) : $attributes;

            $attributesCount = count( $attributes );

            array_splice( $csvArray , 0 , $attributesCount - 1 );
            $formattedArray = array();

            for ($i = 0 ;$i < $attributesCount ;$i++) {

                if (count( $csvArray ) == 0) {
                    break;
                }

                if ($i == 0) {
                    $temporaryRow = array();
                    $csvArray[ 0 ] = explode( "\n" , $csvArray[ 0 ] )[ 1 ];
                }

                if ($i < $attributesCount - 2) {
                    $temporaryRow[ $attributes[ $i ] ] = $csvArray[ $i ];
                } else {
                    $temporaryRow[ $attributes[ $i ] ] = explode( "\n" , $csvArray[ $i ] )[ 0 ];
                }

                if ($i == $attributesCount - 1) {
                    $i = -1;
                    $formattedArray[] = $temporaryRow;
                    array_splice( $csvArray , 0 , $attributesCount - 1 );
                }
            }

            array_pop( $formattedArray );

            return $formattedArray;
        }
    }
