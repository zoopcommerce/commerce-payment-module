<?php

namespace Zoop\Payment\Test;

use Zoop\Store\DataModel\Store;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Provides a dummy active store for phpunit test
 */
class ActiveStoreFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return Store
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $store = new Store;
        $store->setName('Demo');
        $store->setSlug('demo');
        $store->setSubdomain('demo.zoopcommerce.local');
        $store->setEmail('demo@demo.com');

        return $store;
    }
}
