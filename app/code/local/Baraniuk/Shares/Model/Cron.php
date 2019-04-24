<?php

    class Baraniuk_Shares_Model_Cron
    {
        public function baraniuk_shares_update_status () {
            Mage::getModel('baraniuk_shares/module');
            $_model = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES);
            $collection = $_model->getCollection();

            foreach ($collection as $item) {
                $newStatus = Mage::helper(BARANIUK_SHARES::HELPER_ADMIN)->calculateShareStatus($item->getStartDatetime(), $item->getEndDatetime());

                if ($item->getStatus() != $newStatus) {
                    $_model->setData( $item->getData() )
                        ->setStatus( $newStatus )
                        ->save();
                }
            }

            return $this;

        }
    }