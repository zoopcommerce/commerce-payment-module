<?php

namespace Zoop\Payment\Gateway\Anz;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zoop\Payment\Gateway\AbstractGatewayFactory;
use Zoop\Payment\Gateway\Anz\Gateway;

class GatewayFactory extends AbstractGatewayFactory implements FactoryInterface
{
    protected $gatewayServiceName = 'anz';

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Gateway
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $store = $serviceLocator->get('zoop.commerce.store.active');
        
        $gatewayConfig = $this->getConfig($serviceLocator);

        return new Gateway($gatewayConfig);
    }
}
