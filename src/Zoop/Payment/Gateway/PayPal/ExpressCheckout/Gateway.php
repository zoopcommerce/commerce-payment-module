<?php

namespace Zoop\Payment\Gateway\PayPal\ExpressCheckout;

use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Gateway\GatewayInterface;
use Zoop\Payment\Gateway\RedirectGatewayInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Gateway extends AbstractGateway implements GatewayInterface, RedirectGatewayInterface
{
    public function charge($amount, $currency)
    {

    }

    public function redirect($amount, $currency)
    {

    }

    public function refund($amount = 0)
    {

    }
}
