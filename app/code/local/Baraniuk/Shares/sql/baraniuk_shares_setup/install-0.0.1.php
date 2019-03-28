<?php
    /** @var Mage_Core_Model_Resource_Setup $installer*/
    $installer = $this;
    $installer->startSetup();

    $table_name = $this->getTable( 'baraniuk_shares/block' );

    try {
        $table = $installer->getConnection()
            ->newTable( $table_name )
            ->addColumn( 'id' , Varien_Db_Ddl_Table::TYPE_INTEGER , null , array(
                'identity' => true ,
                'unsigned' => true ,
                'nullable' => false ,
                'primary' => true
            ) )
            ->addColumn( 'is_active' , Varien_Db_Ddl_Table::TYPE_BOOLEAN , null , array(
                'nullable' => false
            ) )
            ->addColumn( 'name' , Varien_Db_Ddl_Table::TYPE_TEXT , null , array(
                'nullable' => false
            ) )
            ->addColumn( 'description' , Varien_Db_Ddl_Table::TYPE_TEXT , null , array(
                'nullable' => false
            ) )
            ->addColumn( 'short_description' , Varien_Db_Ddl_Table::TYPE_TEXT , null , array(
                'nullable' => false
            ) )
            ->addColumn( 'image' , Varien_Db_Ddl_Table::TYPE_TEXT , null , array(
                'nullable' => false
            ) )
            ->addColumn( 'create_datetime' , Varien_Db_Ddl_Table::TYPE_TIMESTAMP , null , array(
                'nullable' => false,
                'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
            ) )
            ->addColumn( 'start_datetime' , Varien_Db_Ddl_Table::TYPE_TIMESTAMP , null , array(
                'nullable' => false
            ) )
            ->addColumn( 'end_datetime' , Varien_Db_Ddl_Table::TYPE_TIMESTAMP , null , array(
                'nullable' => true,
                'default'  => null
            ) );

        $installer->getConnection()->createTable($table);
    } catch (Zend_Db_Exception $e) {
        trigger_error("Baraniuk/Shares module have error in setup of 0.0.1 v");
    }


    $installer->endSetup();



?>