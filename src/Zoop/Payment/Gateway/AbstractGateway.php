<?php

namespace Zoop\Payment\Gateway;

use Zend\Stdlib\AbstractOptions;
use Zoop\Order\DataModel\OrderInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractGateway extends AbstractOptions
{
    protected function createTrackingId(OrderInterface $order)
    {
        return sha1($order->getId() . time());
    }
}
