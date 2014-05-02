<?php

namespace Zoop\Payment\Gateway;

use Zoop\Order\DataModel\Order;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface GatewayInterface
{
    /**
     * @param double $amount
     * @param string $currency
     * @param Order $order
     */
    public function charge($amount, $currency, Order $order);

    /**
     * @param double $amount
     * @param Order $order
     */
    public function refund($amount, Order $order);
}
