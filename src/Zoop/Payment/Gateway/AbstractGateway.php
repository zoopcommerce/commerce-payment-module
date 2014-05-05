<?php

namespace Zoop\Payment\Gateway;

use Zend\Stdlib\AbstractOptions;
use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Gateway\GatewayInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractGateway extends AbstractOptions implements GatewayInterface
{
    protected function createTrackingId(OrderInterface $order)
    {
        return sha1($order->getId() . time());
    }
}
