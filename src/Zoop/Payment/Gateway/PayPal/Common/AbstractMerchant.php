<?php

namespace Zoop\Payment\Gateway\Paypal\Common;

use PayPal\Service\PayPalAPIInterfaceServiceService;

class AbstractMerchant
{
    protected $merchantService;

    public function getMerchantService()
    {
        return $this->merchantService;
    }

    public function setMerchantService(PayPalAPIInterfaceServiceService $merchantService)
    {
        $this->merchantService = $merchantService;
    }
}