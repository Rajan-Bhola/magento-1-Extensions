<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Checkoutfees
 */


/**
 * Class Excludeinclude.php
 *
 * @author Artem Brunevski
 */
class Amasty_Checkoutfees_Model_Options_Excludeinclude
{
    const VAR_EXCLUDE = '0';
    const VAR_INCLUDE = '1';
    const VAR_DEFAULT = '2';

    protected $useDefaultOption = false;

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $options =  array(
            self::VAR_EXCLUDE => Mage::helper('amcheckoutfees')->__('No'),
            self::VAR_INCLUDE => Mage::helper('amcheckoutfees')->__('Yes')
        );

        if ($this->useDefaultOption) {
            $options[self::VAR_DEFAULT] = Mage::helper('amcheckoutfees')->__('Default');
        }

        return $options;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = array();
        $arr = $this->toArray();
        foreach($arr as $value => $label){
            $optionArray[] = array(
                'value' => $value,
                'label' => $label
            );
        }
        return $optionArray;
    }

    /**
     * @param $useDefaultOption
     * @return $this
     */
    public function setUseDefaultOption($useDefaultOption)
    {
        $this->useDefaultOption = $useDefaultOption;
        return $this;
    }
}