<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 2/20/19
     * Time: 22:58
     */


    class Baraniuk_IAI_Model_Observer
    {

        public function insertButtonToProductList($observer)
        {

            if ($observer->getData('block')->getData()['type'] === "adminhtml/catalog_product") {
                $observer->getData( 'block' )->addButton( 'iai' , array(
                    'label' => Mage::helper( 'adminhtml' )->__( 'Import of images' ) ,
                    'onclick' => 'redirect()' ,
                    'class' => 'importProducts'
                ) , -100 );

                echo "
                    <script>
                        function redirect() {
                            window.location.href = '" .  Mage::helper("adminhtml")->getUrl("adminhtml/iai/index/") . "';
                        }
                       
                    </script>
                ";
            }


            return $this;
        }
    }