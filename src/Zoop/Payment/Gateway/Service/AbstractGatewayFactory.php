<?php

namespace Zoop\Payment\Gateway\Service;

use \ReflectionClass;
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
        $class = new ReflectionClass($requestedName);
        $gateway = $class->newInstanceArgs();
        
        die(var_dump($gateway));
    }
}
