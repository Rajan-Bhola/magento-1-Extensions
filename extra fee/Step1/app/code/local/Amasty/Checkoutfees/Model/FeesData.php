<?php

/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Checkoutfees
 */
class Amasty_Checkoutfees_Model_FeesData extends Mage_Core_Model_Abstract
{
    /** @var  Amasty_Checkoutfees_Model_Fees */
    protected $_fees;

    /**
     * @return Amasty_Checkoutfees_Model_Fees
     * @throws Mage_Core_Exception
     */
    protected function _getFees()
    {
        if ($this->_fees === null) {
            $this->_fees = Mage::getModel('amcheckoutfees/fees')->load($this->getData('fees_id'));

            if (!$this->_fees->getId())
            {
                Mage::throwException(
                    Mage::helper('amcheckoutfees')->__('Fees not found.')
                );
            }
        }

        return $this->_fees;
    }

    public function _construct()
    {
        parent::_construct();
        $this->_init('amcheckoutfees/feesData');
    }

    public function getTitleForStore()
    {
        $store = Mage::app()->getStore()->getId();
        $title = $this->getData('title') ? unserialize($this->getData('title')) : array();
        if (isset($title[$store]) && !empty($title[$store])) {
            $title = $title[$store];
        } else if (isset($title[0]) && !empty($title[0])) {
            $title = $title[0];
        } else {
            $title = '';
        }

        return $title;
    }

    /**
     * @param bool|false $order
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote($order = false)
    {
        if ($order !== false) {
            if($order instanceof Mage_Sales_Model_Order_Invoice){
                $order = $order->getOrder();
            }
            $quote = Mage::getModel('sales/quote')->loadByIdWithoutStore($order->getQuoteId());
        } else {
            $quote = Mage::getSingleton('checkout/session')->getQuote();
        }
        return $quote;
    }

    /**
     * @return decimal|float
     */
    public function getPercentageTotal($order = false)
    {
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = $this->_getQuote($order);
        $addr = $quote->getShippingAddress();

        $total = 0;

        $items = $addr->getCachedItemsAll();

        if (!$items){ // for situation, where Magento_Weee disabled or items is empty
            $items = $quote->getAllItems();
        }


        foreach ($items as $item){
            $itemPrice = $item->getBasePrice() * $item->getQty();
            if ($this->_getFees()->getDiscountInSubtotal())
                $itemPrice -= $item->getBaseDiscountAmount();

            if ($this->_getFees()->getTaxInSubtotal())
                $itemPrice += $item->getBaseTaxAmount();

            $total += $itemPrice;
        }

        if ($this->_getFees()->getShippingInSubtotal()){
            $total += $addr->getBaseShippingAmount();
            if ($this->_getFees()->getTaxInSubtotal())
                $total += $addr->getBaseShippingTaxAmount();

        }

        return $total;
    }

    public function getFullPrice($order = false, $currency = 'USD')
    {
        $defaultCurrency = Mage::app()->getStore()->getBaseCurrencyCode();
        $quote = $this->_getQuote($order);
        $total = $quote->getBaseSubtotal();

        if ($total && $this->getPriceType()) {
            $total = $this->getPercentageTotal($order) * $this->getPrice() / 100;
        } else {
            $total = $this->getPrice();
        }

        $taxAmount = 0;

        if (Mage::getStoreConfig('amcheckoutfees/general/include_tax_to_price')) {
            $taxAmount = Mage::helper('amcheckoutfees')->calculateTax($total, $quote);
        }

        $total += $taxAmount;

        $total = Mage::helper('directory')->currencyConvert($total, $defaultCurrency, $currency);

        return $total;
    }
}