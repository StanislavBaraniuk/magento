<?php

    class Baraniuk_IAI_Adminhtml_IAIController extends Mage_Adminhtml_Controller_Action
    {

        public function indexAction ()
        {
            $this->loadLayout();
            $this->renderLayout();
        }

        public function importAction ()
        {

            /** @var Baraniuk_IAI_Helper_Parser $parserHelper */
            $parserHelper = Mage::helper( 'baraniuk_iai/parser' );

            /** @var Baraniuk_IAI_Helper_Attributes $attributesHelper */
            $attributesHelper = Mage::helper( 'baraniuk_iai/attributes' );

            $csvArray = str_getcsv( file_get_contents( $_FILES[ 'fileImport' ][ 'tmp_name' ] ) );

            $csvAttributes = $parserHelper->getCsvAttributes( $csvArray );

            $attributesExist = $attributesHelper->attributesExist( $csvAttributes );

            if (!$attributesExist->_status) {

                Mage::getSingleton( 'core/session' )->addError( $attributesExist->_message );
                header( "Location: " . $_SERVER[ "HTTP_REFERER" ] );
            } else {

                $formattedArray = $parserHelper->csvToArray( $csvArray , $csvAttributes );

                foreach ($formattedArray as $item) {
                    $iaiModel = Mage::getModel( "baraniuk_iai/images" );
                    $iaiModel
                        ->setSku( $item[ 'sku' ] )
                        ->setUrl( $item[ 'url' ] )
                        ->setStatus( Mage::getModel()->STATUS_QUEUE )
                        ->setCreateAt(
                            ( new DateTime( 'now' , new DateTimeZone( 'GMT' ) ) )->format( 'Y-m-d H:i' )
                        )
                        ->save();
                }

                Mage::getSingleton( 'core/session' )->addSuccess( $attributesExist->_message );
                header( "Location: " . $_SERVER[ "HTTP_REFERER" ] );
            }

            die();
        }


        public function gridAction ()
        {
            $this->loadLayout();
            $this->getResponse()->setBody(
                $this->getLayout()->createBlock( 'baraniuk_iai/adminhtml_catalog_product_tab_grid' )->toHtml()
            );

            return $this;
        }
    }