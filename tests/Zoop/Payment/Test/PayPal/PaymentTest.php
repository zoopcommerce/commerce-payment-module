<?php

namespace Zoop\Payment\Test\PayPal;

use Zoop\Payment\Test\BaseTest;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\Gateway;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel\GatewayConfig;
use Zoop\Payment\Initiate\InitiateRequest;

class PaymentTest extends BaseTest
{
    public function testInitiateRequest()
    {
        $paypal = $this->getApplicationServiceLocator()->get('zoop.commerce.payment.gateway.paypal.chainedpayment');
        
        /* @var $paypal Gateway */
        $order = $this->createOrder();
        
        // note; amount isn't always the full order amount.
        // We might want to split payments
        $amount = $order->getTotal()->getOrderPrice();
        
        $initiateRequest = new InitiateRequest($amount, $order);
        
        $response = $paypal->initiate($initiateRequest);

        $this->assertTrue($response->isSuccess());
        $this->assertInstanceOf('Zoop\Payment\Initiate\InitiateResponse', $response);
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
