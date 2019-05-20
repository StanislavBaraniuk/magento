<?php

    class Baraniuk_IAI_Model_Cron
    {
        public function process()
        {
            /** @var $helperImages Baraniuk_IAI_Helper_Images * */
            $helperImages = Mage::helper('baraniuk_iai/Images');

            /** @var $modelImages Baraniuk_IAI_Model_Image * */
            $modelImages = Mage::getModel('baraniuk_iai/image');

            /** @var $images array Baraniuk_IAI_Model_Image_Handler $images */
            $images = $modelImages->getImagesForDownloading();

            /** @var $image Baraniuk_IAI_Model_Image_Handler */
            foreach ($images as $image) {
                try {
                    if ($image->getStatus() == $modelImages::STATUS_RETRY) {

                        if (!$helperImages->isToday($image->getLoadAt())) {
                            $image->attach();
                        }

                    } else {
                        $image->attach();
                    }
                } catch (Exception $exception) {
                    Mage::logException($exception);
                }
            }

            return $this;
        }
    }
