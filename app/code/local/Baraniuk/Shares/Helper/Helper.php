<?php

    class Baraniuk_Shares_Helper_Helper extends Mage_Core_Helper_Abstract
    {
        protected $_model;

        public function __construct ()
        {
            $this->_model = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES);
        }

        public function filterDate($date) {
            if (!preg_match("([0-9]{2}-[0-9]{2}-[0-9]{2})", $date)) {
                return false;
            }

            $YMD = explode('-', $date);
            $monthName = date('F', mktime(0, 0, 0, $YMD[1], 10));

            $date = $YMD[2].' '.$monthName.' '.$YMD[0];

            return $date;
        }

        public function filterTime($time) {
            $HMS = explode(':', $time);

            $time = $HMS[0].':'.$HMS[1];

            return $time;
        }

        public function getStartDate ($share) {
            $date = explode(' ', $share[$this->_model::COLUMN_START_DATE])[0];
            return !empty($share[$this->_model::COLUMN_START_DATE]) ? $date : false;
        }

        public function getEndDate ($share) {
            $date = explode(' ', $share[$this->_model::COLUMN_END_DATE])[0];
            return !empty($share[$this->_model::COLUMN_END_DATE]) ? $date : false;
        }

        public function getStartTime ($share) {
            $time = explode(' ', $share[$this->_model::COLUMN_END_DATE])[1];
            return !empty($share[$this->_model::COLUMN_END_DATE]) ? $time : false;
        }

        public function getEndTime ($share) {
            $time = explode(' ', $share[$this->_model::COLUMN_END_DATE])[1];
            return !empty($share[$this->_model::COLUMN_END_DATE]) ? $time : false;
        }

        public function getTitle ($share) {
            return htmlentities($share[$this->_model::COLUMN_TITLE]);
        }

        public function getShortDescription ($share) {
            return htmlentities($share[$this->_model::COLUMN_SHORT_DESCRIPTION]);
        }

        public function getDescription ($share) {
            return htmlentities($share[$this->_model::COLUMN_DESCRIPTION]);
        }

        public function getImage ($share) {
            return $share[$this->_model::COLUMN_IMAGE];
        }

        public function getLink ($share) {
            $link = Mage::getUrl().BARANIUK_SHARES::MODULE.'/index/show/?id='.$share[$this->_model::COLUMN_ID];
            return $link;
        }
    }