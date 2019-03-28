<?php

    class Baraniuk_Shares_Model_Module {

        public function __construct ()
        {
            $moduleConfig = Mage::getConfig()->getModuleConfig('Baraniuk_Shares');
            $paths = BP . DS . 'app' . DS . 'code' . DS . $moduleConfig->codePool[0] . '/Baraniuk/Shares/BARANIUK_SHARES.php';

            require_once $paths;
            return $this;
        }

    }