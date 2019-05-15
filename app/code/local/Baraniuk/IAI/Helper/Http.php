<?php

    class Baraniuk_IAI_Helper_Http extends Mage_Core_Helper_Abstract
    {

        /**
         * @return string
         */
        public function getProtocol(): ?string
        {
            $protocol = $_SERVER[ 'REQUEST_SCHEME' ];

            if ($protocol === null) {
                $isUsingServerVariablesHTTPS= isset($_SERVER[ 'HTTPS' ]);
                if ($isUsingServerVariablesHTTPS) {
                    $protocol = $_SERVER[ 'HTTPS' ] == "on" ? "https" : "http";
                }
            }
            return $protocol;
        }

        /**
         * @param string $url
         *
         * @return array (response, error)
         */
        public function loadImageByUrl(string $url): array
        {

            $error = null;
            $response = null;

            if (filter_var($url, FILTER_VALIDATE_URL)) {

                $requestProtocols = array($this->getProtocol());

                array_unshift($requestProtocols, explode('://', $url)[ 0 ]);

                foreach ($requestProtocols as $protocol) {

                    if (empty($protocol)) {
                        continue;
                    }

                    $this->_replaceURLConnectionType($url, $protocol);

                    $response = $this->_sendRequestForImageLoading($url, $error);

                    if ($response) {
                        break;
                    }
                }
            } else {
                $error = "Url is incorrect";
            }

            return array('response' => $response, 'error' => $error);
        }

        private function _replaceURLConnectionType(&$url, $protocol) {
            $url = explode('://', $url);
            $url[ 0 ] = $protocol;
            $url = implode('://', $url);
        }

        private function _sendRequestForImageLoading($url, &$errorKeeper): ?Zend_Http_Response {

            $client = new Zend_Http_Client($url);

            try {

                $response = $client->request('GET');

                $contentType = explode('/', $response->getHeader('Content-type'));

                if ($contentType[ 0 ] != 'image') {

                    $errorKeeper .= $contentType . empty($contentType) ? ' - is ' : 'Is' . ' not image';
                    return null;
                } else {

                    $errorKeeper = null;
                    return $response;
                }
            } catch (Zend_Http_Client_Exception $e) {

                $errorKeeper .= $e;
                return null;
            }
        }

    }
