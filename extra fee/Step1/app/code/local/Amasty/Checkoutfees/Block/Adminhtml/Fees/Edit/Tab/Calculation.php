<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Checkoutfees
 */


/**
 * Class Calculation.php
 *
 * @author Artem Brunevski
 */
class Amasty_Checkoutfees_Block_Adminhtml_Fees_Edit_Tab_Calculation
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        /** @var Amasty_Checkoutfees_Model_Options_Excludeinclude $excludeIncludeSource */
        $excludeIncludeSource = Mage::getSingleton('amcheckoutfees/options_excludeinclude')
            ->setUseDefaultOption(true);

        $hlp = Mage::helper('amcheckoutfees');

        $form = new Varien_Data_Form();

        $model = Mage::registry('amcheckoutfees_fees');

        $fldInfo = $form->addFieldset('calculation_fieldset', array('legend' => $hlp->__('Calculation')));

        $fldInfo->addField('discount_in_subtotal', 'select', array(
                'label' => $hlp->__('Include discount in subtotal'),
                'title' => $hlp->__('Include discount in subtotal'),
                'name' => 'discount_in_subtotal',
                'values' => $excludeIncludeSource->toOptionArray()
            )
        );

        $fldInfo->addField('tax_in_subtotal', 'select', array(
                'label' => $hlp->__('Include tax in subtotal'),
                'title' => $hlp->__('Include tax in subtotal'),
                'name' => 'tax_in_subtotal',
                'values' => $excludeIncludeSource->toOptionArray()
            )
        );

        $fldInfo->addField('shipping_in_subtotal', 'select', array(
                'label' => $hlp->__('Include shipping in subtotal'),
                'title' => $hlp->__('Include shipping in subtotal'),
                'name' => 'shipping_in_subtotal',
                'values' => $excludeIncludeSource->toOptionArray()
            )
        );

        if (!$model->getId()){
            $model->setData(array(
                'discount_in_subtotal' => Amasty_Checkoutfees_Model_Options_Excludeinclude::VAR_DEFAULT,
                'tax_in_subtotal' => Amasty_Checkoutfees_Model_Options_Excludeinclude::VAR_DEFAULT,
                'shipping_in_subtotal' => Amasty_Checkoutfees_Model_Options_Excludeinclude::VAR_DEFAULT
            ));
        }

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }
}