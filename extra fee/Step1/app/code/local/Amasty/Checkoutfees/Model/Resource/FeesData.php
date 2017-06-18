<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Checkoutfees
 */


class Amasty_Checkoutfees_Model_Resource_FeesData extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('amcheckoutfees/feesData', 'fees_data_id');
    }
}