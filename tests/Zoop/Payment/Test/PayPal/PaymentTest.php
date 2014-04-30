<?php

namespace Zoop\Payment\Test\PayPal;

use Zoop\Payment\Test\BaseTest;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel\GatewayConfig;

class PaymentTest extends BaseTest
{
    public function testGateway()
    {
        $paypal = $this->getApplicationServiceLocator()->get('zoop.commerce.payment.gateway.paypal.chainedpayment');
        die(var_dump($paypal));
    }

    /**
     * @return GatewayConfig
     */
    protected function createPayPalConfig()
    {
        $store = $this->getStore();
        
        $config = new GatewayConfig;
        $config->setSandbox(true);
        $config->setVerified(true);
        $config->setPrimaryReceiver('dev-us-merchant@zoopcommerce.com');
        $config->setLabel('PayPal');
        $config->addCountry('AU');
        $config->addStore($store);
        
        self::getDocumentManager()->persist($config);
        self::getDocumentManager()->flush($config);
        self::getDocumentManager()->clear($config);
        
        return $config;
    }
}
