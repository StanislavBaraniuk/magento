<?php

class Baraniuk_Newproducts_IndexController extends Mage_Core_Controller_Front_Action {
    public function listAction () {
        $this->loadLayout();
        $this->renderLayout();
    }
}