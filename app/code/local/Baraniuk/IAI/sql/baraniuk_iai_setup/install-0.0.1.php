<?php
    /** @var Mage_Core_Model_Resource_Setup $installer */
    $installer = $this;
    $installer->startSetup();

    $table_name = $this->getTable('baraniuk_iai/image');

    try {
        $table = $installer->getConnection()
            ->newTable($table_name)
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ))
            ->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => false,
                'unique' => true
            ))
            ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => false,
                'unique' => true
            ))
            ->addColumn('create_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
            ))
            ->addColumn('load_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                'nullable' => true
            ))
            ->addColumn('size', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => true
            ))
            ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'nullable' => false
            ))
            ->addColumn('error_text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => true
            ));

        $installer->getConnection()->createTable($table);
    } catch (Zend_Db_Exception $e) {
        trigger_error("Baraniuk/IAI module have error in setup of 0.0.1 v");
    }


    $installer->endSetup();
