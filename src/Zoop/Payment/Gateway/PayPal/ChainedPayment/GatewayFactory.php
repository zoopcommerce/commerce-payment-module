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
        return new Gateway($this->getConfig($serviceLocator));
    }
}
