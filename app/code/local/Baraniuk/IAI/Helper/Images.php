<?php

    class Baraniuk_IAI_Helper_Images extends Mage_Core_Helper_Abstract
    {
        /**
         * @var bool Is will file deleted after attaching to the product from module media directory?
         */
        public $_isDeleteFileAfter = true;

        /**
         * @param $bytes
         *
         * @return string
         */
        public function getFileSize(int $bytes): string
        {
            $i = -1;
            $byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
            do {
                $bytes = $bytes / 1000;
                $i++;
            } while ($bytes > 1000);

            return number_format($bytes, 2, '.', ' ') . $byteUnits[ $i ];
        }

        /**
         * @param $date
         *
         * @return bool
         */
        public function isToday(string $date): bool
        {
            $today = new DateTime("now", new DateTimeZone("GMT")); // This object represents current date/time
            $today->setTime(0, 0, 0); // reset time part, to prevent partial comparison

            $match_date = new DateTime($date);
            $match_date->setTime(0, 0, 0); // reset time part, to prevent partial comparison

            $diff = $today->diff($match_date);
            $diffDays = (integer)$diff->format("%R%a"); // Extract days count in interval

            switch ($diffDays) {
                case 0:
                    return true;
                default:
                    return false;
            }
        }
    }
