<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 2/20/19
     * Time: 22:58
     */


    class Baraniuk_Shares_Model_Observer
    {

        function __construct ()
        {
            Mage::getModel('baraniuk_shares/module');
        }

        public function insertToMenu($observer)
        {
            $menu = $observer->getData('menu');
            $tree = $menu->getTree();
            $data = new Varien_Data_Tree_Node(array(
                                                  'name'   => strtoupper(BARANIUK_SHARES::DEVEOPER_NAME.' '.BARANIUK_SHARES::MODULE_NAME),
                                                  'id'     => BARANIUK_SHARES::MODULE,
                                                  'url'    => Mage::getUrl(BARANIUK_SHARES::MODULE.'/index/list'), ), 'id', $tree, $menu);
            $menu->addChild($data);

            return $this;
        }

        public function addShare (Varien_Event_Observer $observer) {
            $_model = Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS);

            $product = $observer->getData('product');

            $productAttraction = Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS)->getCollection()
                ->addFieldToSelect('action_id')
                ->addFieldToFilter('product_id', $product->getEntityId())
                ->getData();

            $html = '';

            if (!empty($productAttraction)) {

                foreach ($productAttraction as $share_id) {

                    $share = Mage::getModel( BARANIUK_SHARES::MODEL_SHARES )->load( $share_id[ 'action_id' ] );

                    if ($share->getIsActive() && $share->getStatus() == 2) {
                        $html .=
                            "<div style='margin-top: 10px; color: red; font-size: 20px; font-weight: bolder;'>SALE</div><div style='border: 1px solid #3399cc; width: 100%; height: 100%; margin: 0'><div style='width: 100%; display: inline-flex; padding: 10px; '><div style=' font-size: 15px; color: #3399cc; float: right; width: 50%; text-align: left'>" . $share->getName() . "</div><div style='width: 50%; text-align: right; color: green'> FROM " . Mage::helper( BARANIUK_SHARES::HELPER_HTML )->filterDate(
                                Mage::helper( BARANIUK_SHARES::HELPER_HTML )->getStartDate( $share )
                            )
                            . ' ' . ( Mage::helper( BARANIUK_SHARES::HELPER_HTML )->filterDate(
                                Mage::helper( BARANIUK_SHARES::HELPER_HTML )->getEndDate( $share )
                            ) ? 'TO' : ''
                            )
                            . ' ' . Mage::helper( BARANIUK_SHARES::HELPER_HTML )->filterDate(
                                Mage::helper( BARANIUK_SHARES::HELPER_HTML )->getEndDate( $share )
                            )
                            . "</div></div><div style='margin: 0 10px 10px 10px; background-color: #3399cc; padding: 10px; color: white; text-align: center'>" . Mage::helper( BARANIUK_SHARES::HELPER_HTML )->getShortDescription( $share ) . "</div></div>";
                    }
                }

            }


            $product->setShortDescription($product->getShortDescription() . $html);

            return $this;
        }
    }

?>