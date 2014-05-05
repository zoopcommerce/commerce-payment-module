<?php

namespace Zoop\Payment\Test\Anz;

use Zoop\Payment\Test\BaseTest;
use Zoop\Payment\Gateway\Anz\Gateway;
use Zoop\Payment\Charge\ChargeRequest;
use Zoop\Payment\Gateway\Anz\DataModel\GatewayConfig;

class PaymentTest extends BaseTest
{
    public function testPaymentRequest()
    {
        $anz = $this->getApplicationServiceLocator()->get('zoop.commerce.payment.gateway.anz');
       
        /* @var $anz Gateway */
        $order = $this->createOrder();
        
        // note; amount isn't always the full order amount.
        // We might want to split payments
        $amount = $order->getTotal()->getOrderPrice();
        
        $chargeRequest = new ChargeRequest($amount, $order);
        
        $response = $anz->charge($chargeRequest);
        
        $this->assertTrue($response->isSuccess());
        $this->assertInstanceOf('Zoop\Payment\Charge\ChargeResponse', $response);
        
        $transaction = $response->getTransaction();
        $this->assertInstanceOf('Zoop\Payment\DataModel\TransactionInterface', $transaction);
        $this->assertEquals($amount, $transaction->getAmount());
        $this->assertTrue($transaction->isComplete());
    }
}
