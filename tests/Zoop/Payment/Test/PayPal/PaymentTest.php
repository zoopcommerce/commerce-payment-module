<?php

namespace Zoop\Payment\Test\PayPal;

use Zoop\Payment\Test\BaseTest;
use Zoop\Order\DataModel\Order;
use Zoop\Order\DataModel\Total;
use Zoop\Order\DataModel\Commission;
use Zoop\Common\DataModel\Address;
use Zoop\Common\DataModel\Currency;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\Gateway;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel\GatewayConfig;

class PaymentTest extends BaseTest
{
    public function testPaymentRequest()
    {
        $paypal = $this->getApplicationServiceLocator()->get('zoop.commerce.payment.gateway.paypal.chainedpayment');
        
        /* @var $paypal Gateway */
        $order = $this->createOrder();
        
        $response = $paypal->charge(
            $order->getTotal()->getOrderPrice(),
            $order->getTotal()->getCurrency()->getCode(),
            $order
        );
        die(Var_dump($response));
        $this->assertTrue($response->isSuccess());
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

    /**
     * @return Order
     */
    protected function createOrder()
    {
        $store = $this->getStore();
        
        $order = new Order;
        $order->setStore($store);
        $order->setFirstName('John');
        $order->setLastName('Doe');
        
        $currency = new Currency;
        $currency->setCode('AUD');
        $currency->setSymbol('$');
        $currency->setName('Australian Dollar');
        
        $total = new Total;
        $total->setShippingPrice(10);
        $total->setProductPrice(100);
        $total->setProductQuantity(1);
        $total->setDiscountPrice(0);
        $total->setTaxPrice(11);
        $total->setOrderPrice(110);
        $total->setCurrency($currency);
        
        $order->setTotal($total);
        
        $commission = new Commission;
        $commission->setAmount(4.4);
        $commission->setCharged(4.4);
        
        $order->setCommission($commission);
        
        self::getDocumentManager()->persist($order);
        self::getDocumentManager()->flush($order);
        self::getDocumentManager()->clear($order);
        return $order;
    }
}
