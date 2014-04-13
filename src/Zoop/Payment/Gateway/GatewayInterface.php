<?php

namespace Zoop\Payment\Gateway;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface GatewayInterface
{
    public function charge($amount, $currency);

    public function refund($amount = 0);
}
