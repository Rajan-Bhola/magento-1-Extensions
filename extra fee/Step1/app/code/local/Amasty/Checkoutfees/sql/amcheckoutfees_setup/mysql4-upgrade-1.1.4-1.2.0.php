<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Checkoutfees
 */

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


$installer->getConnection()->addColumn(
    $this->getTable('amcheckoutfees/fees'),
    'discount_in_subtotal',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default' => Amasty_Checkoutfees_Model_Options_Excludeinclude::VAR_DEFAULT,
        'comment' => 'Discount in subtotal'
    )
);

$installer->getConnection()->addColumn(
    $this->getTable('amcheckoutfees/fees'),
    'tax_in_subtotal',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default' => Amasty_Checkoutfees_Model_Options_Excludeinclude::VAR_DEFAULT,
        'comment' => 'Tax in subtotal'
    )
);

$installer->getConnection()->addColumn(
    $this->getTable('amcheckoutfees/fees'),
    'shipping_in_subtotal',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default' => Amasty_Checkoutfees_Model_Options_Excludeinclude::VAR_DEFAULT,
        'comment' => 'Shipping in subtotal'
    )
);

$this->endSetup();