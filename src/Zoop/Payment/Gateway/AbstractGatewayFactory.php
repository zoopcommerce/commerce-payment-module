<?php

namespace Zoop\Payment\Gateway;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractGatewayFactory
{
    public function getConfig(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop']['payment']['gateways'];

        if (isset($config[$this->gatewayServiceName])) {
            $config = $config[$this->gatewayServiceName];
        } else {
            return [];
        }

        if (is_bool($config)) {
            return [];
        }

        return $config;
    }
}
