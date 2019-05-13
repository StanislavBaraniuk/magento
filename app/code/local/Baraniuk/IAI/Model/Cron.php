<?php

    class Baraniuk_IAI_Model_Cron
    {
        public function process()
        {
            /** @var $helperImages Baraniuk_IAI_Helper_Images * */
            $helperImages = Mage::helper('baraniuk_iai/Images');

            /** @var $modelImages Baraniuk_IAI_Model_Image * */
            $modelImages = Mage::getModel('baraniuk_iai/image');

            /** @var $images array Baraniuk_IAI_Model_Image $images */
            $images = $modelImages->loadImages();

            /** @var $image Baraniuk_IAI_Model_Image_Import_Downloader */
            foreach ($images as $image) {
                if ($image->getStatus() == $modelImages::STATUS_RETRY) {

                    if (!$helperImages->isToday($image->getLoadAt())) {
                        $image->attach();
                    }

                } else {
                    $image->attach();
                }
            }

            return $this;
        }
    }
