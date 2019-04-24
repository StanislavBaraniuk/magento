<?php
    /** @var Mage_Core_Model_Resource_Setup $installer*/

    $installer = $this;
    $installer->startSetup();

    try {
        $table = $installer->getConnection()
            ->newTable( $this->getTable( 'baraniuk_shares/products' ))
            ->addColumn( 'id' , Varien_Db_Ddl_Table::TYPE_INTEGER , null , array(
                'identity'  => true ,
                'unsigned'  => true ,
                'nullable'  => false ,
                'primary'   => true
            ) )
            ->addColumn( 'action_id' , Varien_Db_Ddl_Table::TYPE_INTEGER , null , array(
                'nullable'  => false
            ) )
            ->addColumn( 'product_id' , Varien_Db_Ddl_Table::TYPE_INTEGER , null , array(
                'nullable'  => false,
                'unique'  => true
            ) );

        $installer->getConnection()->createTable($table);
    } catch (Zend_Db_Exception $e) {
        trigger_error("Baraniuk/Shares module have error in upgrade of 0.0.2 v - 0.0.3 v");
    }

    $installer->endSetup();
