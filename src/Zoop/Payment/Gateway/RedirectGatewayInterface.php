<?php

namespace Zoop\Payment\Gateway;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface RedirectGatewayInterface
{
    public function redirect($amount, $currency);
}
