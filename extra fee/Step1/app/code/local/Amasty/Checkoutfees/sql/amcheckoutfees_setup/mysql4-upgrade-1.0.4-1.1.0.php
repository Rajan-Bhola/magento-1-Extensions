<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Checkoutfees
 */

$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('amcheckoutfees/fees'),
    'autoapply',
    "INT(1) COMMENT 'Automatic Apply'"
);

$this->endSetup();