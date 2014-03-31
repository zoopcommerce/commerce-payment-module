<?php

namespace Zoop\Payment\Provider\PayPal\ChainedPayment;

use Zoop\Payment\Provider\AbstractProvider;
use Zoop\Payment\Provider\ProviderInterface;
use Zoop\Payment\Provider\RedirectProviderInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Payment extends AbstractProvider implements ProviderInterface, RedirectProviderInterface
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
