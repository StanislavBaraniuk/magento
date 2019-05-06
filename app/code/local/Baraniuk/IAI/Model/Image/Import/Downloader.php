<?php

    class Baraniuk_IAI_Model_Image_Import_Downloader
    {

        /** @var $_helperFileWorker Baraniuk_IAI_Helper_FileWorker * */
        static private $_helperFileWorker;

        /** @var $_helperHttp Baraniuk_IAI_Helper_Http * */
        static private $_helperHttp;

        /** @var $_helperImages Baraniuk_IAI_Helper_Images * */
        static private $_helperImages;

        /** @var $_modelImage Baraniuk_IAI_Model_Image * */
        static private $_modelImage;

        /** @var $_image Baraniuk_IAI_Model_Image * */
        private $_image = null;

        public $loadDatetime;
        public $status;
        public $size;
        public $error;

        /**
         * Baraniuk_IAI_Model_Image constructor.
         *
         * @param Baraniuk_IAI_Model_Image $image
         */
        public function __construct(Baraniuk_IAI_Model_Image $image)
        {

            $this->_image = $image;

            if (empty(self::$_helperFileWorker)) {
                self::$_helperFileWorker = Mage::helper('baraniuk_iai/FileWorker');
                self::$_helperHttp = Mage::helper('baraniuk_iai/Http');
                self::$_helperImages = Mage::helper('baraniuk_iai/Images');
                self::$_modelImage = Mage::getModel('baraniuk_iai/Image');
            }
        }

        public function getHelperFileWorker()
        {
            return self::$_helperFileWorker;
        }

        public function getHelperHttp()
        {
            return self::$_helperHttp;
        }

        public function getHelperImages()
        {
            return self::$_helperImages;
        }

        /**
         * @param array|null $request
         * @param null $path
         *
         * @return bool
         */
        public function attach(array $request = null, $path = null): bool
        {

            $url = $this->_image->getUrl();

            if ($request === null) {
                $request = self::$_helperHttp->loadImageByUrl($url);
            } else {
                if (isset($request[ 'error' ]) && isset($request[ 'response' ])) {
                    if (!($request[ 'response' ] instanceof Zend_Http_Response)) {
                        return false;
                    }
                }
            }

            $this->error = $request[ 'error' ];
            $response = $request[ 'response' ];

            if (empty($this->error)) {

                $this->size = $response->getHeader('Content-length');

                if ($path === null) {
                    $path = $this->generateImagePath($response, $url);
                }

                $content = $response->getBody();

                if (self::$_helperFileWorker->createFile($path, $content)) {
                    /** @var Mage_Catalog_Model_Product $prod */
                    $productCollection = Mage::getModel('catalog/product')->getCollection()
                        ->addFieldToFilter('sku', $this->_image->getSku());

                    foreach ($productCollection as $product) {

                        /** @var Mage_Catalog_Model_Product $prod */
                        $prod = Mage::getModel('catalog/product')->load($product->getId());

                        if ($this->attachImageToProduct($path, $prod)) {
                            $this->status = self::$_modelImage::STATUS_LOADED;
                        } else {
                            $this->error .= "\r\n" . "Couldn't to attach file";
                            $this->status = self::$_modelImage::STATUS_ERROR;
                        }
                    }
                } else {
                    $this->status = self::$_modelImage::STATUS_ERROR;
                    $this->error .= "\r\n" . "Couldn't to create of the file";
                }
            } else {
                $this->size = 0;
                $this->status = self::$_modelImage::STATUS_ERROR;
            }

            if ($response !== null && $response->getStatus() === 404) {
                $this->status = self::$_modelImage::STATUS_RETRY;
                $this->error .= "\r\n" . "404 Page not found";
            }

            $this->loadDatetime = (new DateTime('now', new DateTimeZone('GMT')))->format('Y-m-d H:i');

            $this->update();

            return true;
        }

        /**
         * @var $path string Path to image file
         * @var $product Mage_Catalog_Model_Product Product object
         *
         * @return bool Does was image attached
         */
        public function attachImageToProduct(string $path, Mage_Catalog_Model_Product &$product): bool
        {

            try {

                $imageAttributes = array();

                if ($product->getData('image') == 'no_selection') {
                    array_push($imageAttributes, 'image');
                }

                if ($product->getData('small_image') == 'no_selection') {
                    array_push($imageAttributes, 'small_image');
                }

                if ($product->getData('thumbnail') == 'no_selection') {
                    array_push($imageAttributes, 'thumbnail');
                }


                $product->setMediaGallery(array('images' => array(), 'values' => array()));
                $product->addImageToMediaGallery($path, $imageAttributes, false, false);
                $product->save();

                if (self::$_helperImages->_isDeleteFileAfter) {
                    /** @see Baraniuk_IAI_Helper_FileWorker */
                    Mage::helper('baraniuk_iai/fileWorker')->deleteFile($path);
                }

                return true;
            } catch (Exception $exception) {

                return false;
            }
        }

        /**
         * @param Zend_Http_Client $response
         * @param string $url
         *
         * @return string
         */
        public function generateImagePath(Zend_Http_Response $response, string $url): string
        {

            /** @var $helperFileWorker Baraniuk_IAI_Helper_FileWorker * */
            $helperFileWorker = Mage::helper('baraniuk_iai/FileWorker');

            $contentType = explode('/', $response->getHeader('Content-type'));

            $path = $helperFileWorker->generateName(
                Mage::getBaseDir('media') . DS . 'baraniuk_iai' . DS . basename($url) . '.' . $contentType[ 1 ]
            );

            return $path;
        }

        /**
         *  Update row in DB
         */
        public function update()
        {
            $this->_image
                ->setLoadAt($this->loadDatetime)
                ->setSize($this->size)
                ->setStatus($this->status)
                ->setErrorText($this->error)
                ->save();
        }

        /**
         * @param $name
         * @param $arguments
         *
         * @return mixed
         */
        public function __call($name, $arguments)
        {
            $type = substr($name, 0, 3);

            switch ($type) {
                case 'get':
                    return $this->_image->$name();
                    break;
                case 'set':
                    return $this->_image->$name();
                    break;
                case 'uns':
                    return $this->_image->$name();
                    break;
                case 'has':
                    return $this->_image->$name();
                    break;
            }
        }
    }
