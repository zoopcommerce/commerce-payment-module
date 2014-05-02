<?php

namespace Zoop\Payment\Gateway;

use Zoop\Order\DataModel\Order;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface RedirectGatewayInterface
{
    /**
     * @param double $amount
     * @param string $currency
     * @param Order $order
     */
    public function redirect($amount, $currency, Order $order);
}
