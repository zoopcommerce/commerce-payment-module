<?php

namespace Zoop\Payment\Gateway;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */

interface GatewayInterface
{
    /**
     * @param double $amount
     * @param string $currency
     */
    public function charge($amount, $currency);

    /**
     * @param double $amount
     */
    public function refund($amount = 0);
}
