<?php

namespace Zoop\Payment\Gateway;

use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Gateway\GatewayResponseInterface;

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
     * @param GatewayResponseInterface $response
     */
    public function charge($amount, $currency, OrderInterface $order);

    /**
     * @param double $amount
     * @param Order $order
     * @param GatewayResponseInterface $response
     */
    public function refund($amount, OrderInterface $order);
}
