<?php

    class Baraniuk_Shares_Helper_Data extends Mage_Core_Helper_Abstract
    {
        public function calculateShareStatus ($startDate, $endDate) {

//            date_default_timezone_set('GMT');

            $dteStart   = new DateTime($startDate);
            $dteEnd     = empty($endDate) ? "" : new DateTime($endDate);

            if ($dteStart <= new DateTime('now') && $dteEnd >= new DateTime('now')) {
                return Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)::STATUS_OPEN;
            }

            if ($dteStart >= new DateTime('now')) {
                return Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)::STATUS_WAIT;
            }

            if ($dteEnd < new DateTime('now') && !empty($dteEnd)) {
                return Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)::STATUS_CLOSE;
            } elseif ($dteEnd < new DateTime('now') && empty($dteEnd)) {
                return Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)::STATUS_OPEN;
            }

            return $this;
        }

        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXY Z';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        function randomGen($min, $max, $quantity) {
            $numbers = range($min, $max);
            shuffle($numbers);
            return array_slice($numbers, 0, $quantity);
        }

    }