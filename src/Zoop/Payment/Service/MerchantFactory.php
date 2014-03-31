<?php

namespace Zoop\Payment\Service\Paypal;

use PayPal\Service\PayPalAPIInterfaceServiceService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MerchantFactory implements FactoryInterface
{
    use PaypalConfigTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //zoop paypal config
        $paypalConfig = $serviceLocator->get('config')['zoop']['payment']['paypal'];

        return new PayPalAPIInterfaceServiceService($this->compileConfig($paypalConfig));
    }

}