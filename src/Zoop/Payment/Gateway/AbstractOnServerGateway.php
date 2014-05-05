<?php

namespace Zoop\Payment\Gateway;

use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Charge\ChargeInterface;
use Zoop\Payment\Refund\RefundInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractOnServerGateway extends AbstractGateway implements
    ChargeInterface,
    RefundInterface
{
    
}
