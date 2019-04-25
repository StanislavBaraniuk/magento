<?php

    class Baraniuk_IAI_Helper_Http
    {


        /**
         * @return bool
         */
        public function isHttps (): bool
        {

            if ($_SERVER[ 'REQUEST_SCHEME' ] === 'https') {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @return string
         */
        public function getProtocol (): string
        {

            return $_SERVER[ 'REQUEST_SCHEME' ];
        }

        /**
         * @param string $url
         *
         * @return array (response, error)
         */
        public function loadImageByUrl ( string &$url ): array
        {

            $url = str_replace( "\r" , '' , $url );
            $url = str_replace( "\n" , '' , $url );
            $url = str_replace( "\t" , '' , $url );

            $error = null;
            $response = null;

            $requestProtocols = array( $this->getProtocol() );

            array_unshift( $requestProtocols , explode( '://' , $url )[ 0 ] );

            foreach ($requestProtocols as $protocol) {

                try {

                    $url = explode( '://' , $url );
                    $url[ 0 ] = $protocol;
                    $url = implode( '://' , $url );

                    $client = new Zend_Http_Client( $url );

                    $response = $client->request( 'GET' );

                    $contentType = explode( '/' , $response->getHeader( 'Content-type' ) );

                    if ($contentType[ 0 ] != 'image') {

                        $error .= $contentType . empty( $contentType ) ? ' - is ' : 'Is' . ' not image';
                    } else {
                        $error = null;
                        break;
                    }


                } catch (Zend_Http_Client_Exception $e) {

                    $error .= $e;
                }
            }

            return array( 'response' => $response , 'error' => $error );
        }

    }