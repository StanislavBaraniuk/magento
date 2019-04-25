<?php

    class Baraniuk_IAI_Model_Cron
    {
        public function process ()
        {
            /** @var $helperImages Baraniuk_IAI_Helper_Images * */
            $helperImages = Mage::helper( 'baraniuk_iai/Images' );

            /** @var $modelImages Baraniuk_IAI_Model_Images * */
            $modelImages = Mage::getModel( 'baraniuk_iai/images' );

            $images = $helperImages->loadImages();

            foreach ($images as $image) {
                if ($image->getStatus() == $modelImages::STATUS_RETRY) {

                    if (!$helperImages->isToday( $image->getLoadAt() )) {
                        $image->attach();
                    }

                } else {
                    $image->attach();
                }
            }

            return $this;
        }
    }