<?php

namespace Zoop\Payment\Provider;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface RedirectProviderInterface
{
    public function redirect($amount, $currency);
}
