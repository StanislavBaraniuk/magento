<?php

class Baraniuk_Newproducts_IndexController extends Mage_Core_Controller_Front_Action {
    public function listAction () {
//        Mage::dispatchEvent('page_block_html_topmenu_gethtml_after', array(
//            'menu' => new Varien_Data_Tree_Node(array(), 'root', new Varien_Data_Tree()),
//            'html' => '<div>asdasd</div>'
//        ));

        $this->loadLayout();
        $this->renderLayout();
    }
}