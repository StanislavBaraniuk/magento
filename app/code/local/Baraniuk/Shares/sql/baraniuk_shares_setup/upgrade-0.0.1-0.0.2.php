<?php

    /** @var Mage_Core_Model_Resource_Setup $installer*/
    $installer = $this;
    $connection = $installer->getConnection();

    $installer->startSetup();

    try {
        $installer->getConnection()
            ->addColumn($installer->getTable('baraniuk_shares/block'),
                        'status',
                        array(
                            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                            'nullable' => false,
                            "after" => 'id',
                            'comment' => '1 - wait, 2 - work, 3 - close'
                        )
            );
    } catch (Zend_Db_Exception $e) {
        trigger_error("Baraniuk/Shares module have error in upgrade of 0.0.1 v - 0.0.2 v");
    }

    $installer->endSetup();
?>