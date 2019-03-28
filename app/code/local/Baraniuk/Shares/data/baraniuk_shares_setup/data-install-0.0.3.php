<?php

    Mage::getModel('baraniuk_shares/module');

    $defaultShares = [];
    $products = [];

    for ($i = 0; $i < 50; $i++) {
        $startDate  = date("Y-m-d H:i", rand(1546300800,1561852800));
        $endDate    = date("Y-m-d H:i", rand(1561852800,1577664000));

        try {
            $defaultShares[] = array(
                'status' => Mage::helper( BARANIUK_SHARES::HELPER_ADMIN )->calculateShareStatus( $startDate , $endDate ) ,
                'is_active' => 1,
                'name' => Mage::helper( BARANIUK_SHARES::HELPER_ADMIN )->generateRandomString(rand(10 , 20)),
                'description' => Mage::helper( BARANIUK_SHARES::HELPER_ADMIN )->generateRandomString(rand(50 , 100)),
                'short_description' => Mage::helper( BARANIUK_SHARES::HELPER_ADMIN )->generateRandomString(rand(20 , 50)),
                'image' =>  BARANIUK_SHARES::IMAGE_SHARE_DEFAULT,
                'start_datetime' => $startDate ,
                'end_datetime' => $endDate
            );

            $products[$i+1] = Mage::helper( BARANIUK_SHARES::HELPER_ADMIN )->randomGen(1, 906, rand(5,20));

        } catch (Exception $e) {
            trigger_error('Error in loading of the sample data Baraniuk_Shares');
        }
    }

    foreach ($defaultShares as $share) {
        Mage::getModel(BARANIUK_SHARES::MODEL_SHARES )
            ->setData($share)
            ->save();
    }

    foreach ($products as $shareId => $productsIds) {
        foreach ($productsIds as $productId) {
            Mage::getModel(BARANIUK_SHARES::MODEL_PRODUCTS )
                ->setActionId( $shareId )
                ->setProductId( $productId )
                ->save();
        }
    }
