<?php

namespace Zoop\Payment\Gateway;

use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Gateway\GatewayResponseInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface RedirectGatewayInterface
{
    /**
     * @param double $amount
     * @param string $currency
     * @param OrderInterface $order
     * @param GatewayResponseInterface $response
     */
    public function finalize($amount, $currency, OrderInterface $order);
}
