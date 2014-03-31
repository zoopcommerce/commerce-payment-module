<?php
/**
 * @package    Zoop
 * @license    MIT
 */

namespace Zoop\Payment\Service;

use Zoop\Payment\Crypt\Password;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class CryptPasswordFactory implements FactoryInterface
{

    /**
     *
     * @param  \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('config')['zoop']['payment']['crypt_password'];

        return new Password($options['key'], $options['salt']);
    }
}
