<?php

class Baraniuk_Shares_IndexController extends Mage_Core_Controller_Front_Action {

    public function _construct ()
    {
        Mage::getModel('baraniuk_shares/module');
        parent::_construct();
    }

    public function listAction () {

        $this->loadLayout();
        $this->renderLayout();

        return $this;
    }

    public function showAction () {
        $this->loadLayout();
        $this->renderLayout();

        return $this;
    }

}
