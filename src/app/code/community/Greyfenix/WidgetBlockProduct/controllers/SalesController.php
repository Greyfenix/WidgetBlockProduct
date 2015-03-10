<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento
 *
 * DISCLAIMER
 *
 * This custom module is owned by Greyfenix Media and it licensed under greyfenix.com.au
 * Please do not modify this file cause you will lose the modified when upgrading it
 *
 * @category  Module
 * @package   WidgetBlockProduct
 * @author    Dimas Putra <dp@greyfenix.com.au>
 * @copyright Greyfenix adapt MIT license
 * @license   Greyfenix http://greyfenix.com.au/
 * @link      http://greyfenix.com.au/
 */
class Greyfenix_WidgetBlockProduct_SalesController extends Mage_Core_Controller_Front_Action
{
    public function fetchAction()
    {
        $result = array();
        $time = $this->getRequest()->getParam('time');
        if ($time) {
            $requestedTime = gmdate('Y-m-d H:m:s', Mage::getModel('core/date')->timestamp(time('-' . $time . ' seconds')));

            $orderCollection = Mage::getModel('sales/order')->getCollection()
                ->addFieldToFilter('created_at', array('from' => $requestedTime));

            // improve speed of the query to have limit number
            $orderCollection->getSelect()->limit(5);

            foreach($orderCollection as $orders) {
                $result = $orders->getCustomerName();
            }
        }

        return json_encode($result);

    }
}
