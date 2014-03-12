<?php

namespace Zoop\Payment\Provider;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface ProviderInterface
{
    public function charge($amount, $currency);

    public function refund($amount = 0);
}
