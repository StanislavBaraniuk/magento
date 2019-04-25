<?php

    class Baraniuk_IAI_Helper_Images
    {
        /**
         * @var bool Is will file deleted after attaching to the product from module media directory?
         */
        public $_isDeleteFileAfter = true;

        /**
         * @return Baraniuk_IAI_Model_Image
         */
        public function loadImages (): Generator
        {

            $imagesModel = Mage::getModel( 'baraniuk_iai/images' );

            $images = $imagesModel->getCollection()
                ->addFieldToFilter( $imagesModel::COLUMN_LOAD_STATUS , array( "lt" => $imagesModel::STATUS_LOADED ) );

            foreach ($images as $image) {
                yield new Baraniuk_IAI_Model_Image( $image );
            }
        }

        public function getFileSize ( $bytes )
        {
            $i = -1;
            $byteUnits = [ ' kB' , ' MB' , ' GB' , ' TB' , 'PB' , 'EB' , 'ZB' , 'YB' ];
            do {
                $bytes = $bytes / 1000;
                $i++;
            } while ($bytes > 1000);

            return number_format( $bytes , 2 , '.' , ' ' ) . $byteUnits[ $i ];
        }

        public function isToday ( $date )
        {

            date_default_timezone_set( ( new DateTimeZone( "GMT" ) ) );

            $today = new DateTime(); // This object represents current date/time
            $today->setTime( 0 , 0 , 0 ); // reset time part, to prevent partial comparison

            $match_date = new DateTime( $date );
            $match_date->setTime( 0 , 0 , 0 ); // reset time part, to prevent partial comparison

            $diff = $today->diff( $match_date );
            $diffDays = (integer) $diff->format( "%R%a" ); // Extract days count in interval

            switch ($diffDays) {
                case 0:
                    return true;
                default:
                    return false;
            }
        }

//        /**
//         * @var $path string Path to image file
//         * @var $product Mage_Catalog_Model_Product Product object
//         *
//         * @return bool Does was image attached
//         */
//        public function attachImageToProduct (string $path , Mage_Catalog_Model_Product &$product) : bool {
//
//            try {
//
//                $imageAttributes = array();
//
//                if ($product->getData( 'image' ) == 'no_selection') {
//                    array_push( $imageAttributes , 'image' );
//                }
//
//                if ($product->getData( 'small_image' ) == 'no_selection') {
//                    array_push( $imageAttributes , 'small_image' );
//                }
//
//                if ($product->getData( 'thumbnail' ) == 'no_selection') {
//                    array_push( $imageAttributes , 'thumbnail' );
//                }
//
//                if (
//                    $product->setMediaGallery( array( 'images' => array() , 'values' => array() ) )
//                        ->addImageToMediaGallery( $path , $product , false , false )
//                        ->save()
//                ) {
//                    if ($this->_isDeleteFileAfter) {
//                        Mage::helper( 'baraniuk_iai/fileWorker' )->deleteFile($path);
//                    }
//                }
//
//                return true;
//            } catch (Exception $exception) {
//
//                return false;
//            }
//        }
//
//        /**
//         * @param Zend_Http_Client $response
//         * @param string $url
//         *
//         * @return string
//         */
//        public function generateImagePath (Zend_Http_Response $response, string $url) : string {
//
//            /** @var $helperFileWorker Baraniuk_IAI_Helper_FileWorker **/
//            $helperFileWorker = Mage::helper('baraniuk_iai/FileWorker');
//
//            $contentType = explode('/', $response->getHeader('Content-type'));
//
//            $path = $helperFileWorker->generateName(
//                Mage::getBaseDir('media') . DS . 'baraniuk_iai' . DS . basename($url) . '.' . $contentType[1]
//            );
//
//            return $path;
//        }
//
//        public function updateImageRow () {
//
//        }
    }