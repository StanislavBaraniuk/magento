<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 2/20/19
     * Time: 22:58
     */


    class Baraniuk_Newproducts_Model_Observer
    {
        public function insertToMenu($observer)
        {
            $menu = $observer->getData('menu');
            $tree = $menu->getTree();
            $data = new Varien_Data_Tree_Node(array(
                                                  'name'   => 'Baraniuk New products',
                                                  'id'     => 'Baraniuk_Newporduct_List',
                                                  'url'    => Mage::getUrl('baraniuk_newproducts/index/list'), ), 'id', $tree, $menu);
            $menu->addChild($data);
            return $this;
        }
    }