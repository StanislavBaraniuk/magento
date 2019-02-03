<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 2/3/19
 * Time: 11:05
 */

class Baraniuk_Hellomagento_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction () {
        echo "Hello, Magento!";
    }

    public function listAction () {
        $this->indexAction();
    }
}