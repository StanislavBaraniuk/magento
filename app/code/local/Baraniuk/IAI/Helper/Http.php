<?php

    class Baraniuk_IAI_Helper_Http
    {

        /**
         * @return string
         */
        public function getProtocol(): string
        {

            return $_SERVER[ 'REQUEST_SCHEME' ];
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

                    try {

                        $url = explode('://', $url);
                        $url[ 0 ] = $protocol;
                        $url = implode('://', $url);

                        $client = new Zend_Http_Client($url);

                        $response = $client->request('GET');

                        $contentType = explode('/', $response->getHeader('Content-type'));

                        if ($contentType[ 0 ] != 'image') {

                            $error .= $contentType . empty($contentType) ? ' - is ' : 'Is' . ' not image';
                        } else {
                            $error = null;
                            break;
                        }


                    } catch (Zend_Http_Client_Exception $e) {

                        $error .= $e;
                    }
                }
            } else {
                $error = "Url is incorrect";
            }

            return array('response' => $response, 'error' => $error);
        }

    }
