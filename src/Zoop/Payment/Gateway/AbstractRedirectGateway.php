<?php

namespace Zoop\Payment\Gateway;

use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Charge\ChargeInterface;
use Zoop\Payment\Refund\RefundInterface;
use Zoop\Payment\Initiate\InitiateInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractRedirectGateway extends AbstractGateway implements
    InitiateInterface,
    ChargeInterface,
    RefundInterface
{
    
}
