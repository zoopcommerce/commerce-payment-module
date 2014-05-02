<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zoop\Payment\Gateway\AbstractGatewayFactory;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\Gateway;

class GatewayFactory extends AbstractGatewayFactory implements FactoryInterface
{
    protected $gatewayServiceName = 'paypal.chainedpayment';

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $store = $serviceLocator->get('zoop.commerce.store.active');
        
        $gatewayConfig = $this->getConfig($serviceLocator);
        $gatewayConfig['returnUrl'] = 'http://' . $store->getDomain();
        $gatewayConfig['cancelUrl'] = 'http://' . $store->getDomain();

        return new Gateway($gatewayConfig);
    }
}
