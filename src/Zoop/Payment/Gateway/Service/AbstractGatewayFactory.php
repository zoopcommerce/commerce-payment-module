<?php

namespace Zoop\Payment\Gateway\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class AbstractGatewayFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $gateway = 'Gateway';
        return strpos($requestedName, 'Zoop\Payment\Gateway') === 0 && substr($requestedName, -strlen($gateway)) === $gateway;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $service = new \stdClass();

        $service->name = $requestedName;

        return $service;
    }

}
