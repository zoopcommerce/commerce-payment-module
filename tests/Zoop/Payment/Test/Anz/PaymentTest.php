<?php

namespace Zoop\Payment\Test\Anz;

use Zoop\Payment\Test\BaseTest;
use Zoop\Order\DataModel\Order;
use Zoop\Order\DataModel\Total;
use Zoop\Order\DataModel\Commission;
use Zoop\Common\DataModel\Address;
use Zoop\Common\DataModel\Currency;
use Zoop\Payment\Gateway\Anz\Gateway;
use Zoop\Payment\Gateway\Anz\DataModel\GatewayConfig;

class PaymentTest extends BaseTest
{
    public function testPaymentRequest()
    {
        $anz = $this->getApplicationServiceLocator()->get('zoop.commerce.payment.gateway.anz');
       
        /* @var $anz Gateway */
        $order = $this->createOrder();
        
        $response = $anz->charge(
            $order->getTotal()->getOrderPrice(),
            $order->getTotal()->getCurrency()->getCode(),
            $order
        );
        $this->assertTrue($response->isSuccess());
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
