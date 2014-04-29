<?php

namespace Zoop\Payment\Test\Controller;

use Zoop\Payment\Test\BaseTest;

class PaymentTest extends BaseTest
{
    public function testPayPal()
    {
        $paypal = $this->getApplicationServiceLocator()->get('Zoop\Payment\Gateway\PayPal\ChainedPayment\Gateway');
        
    }

}
