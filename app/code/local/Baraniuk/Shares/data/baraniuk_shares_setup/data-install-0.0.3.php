<?php
//
//    $defaultAction = [];
//
//    for ($i = 0; $i < 10; $i++) {
//        $startDate = '2019-' . rand(1, 6) . '-' . rand(1, 15);
//        $startDate = '2019-' . rand(6, 12) . '-' . rand(15, 30);
//
//        $defaultAction[] = array(
//            'status'            => Mage::helper('baraniuk_shares/data')->calculateShareStatus(),
//            'is_active'         => '1',
//            'name'              => 'Акція 1',
//            'description'       => 'Повний опис акції Повний опис акції Повний опис акції Повний опис акції Повний опис акції',
//            'short_description' => 'Короткий опис',
//            'image'             => 'action.jpg',
//            'create_datetime'   => '10.02.2019 20:10',
//            'start_datetime'    => '10.02.2019 20:10',
//            'end_datetime'     => '31.03.2019 23:59'
//        )
//    }
//
//    foreach ($defaultAction as $action) {
//        Mage::getModel('baraniuk_shares/block')
//            ->setData($action)
//            ->save();
//    }