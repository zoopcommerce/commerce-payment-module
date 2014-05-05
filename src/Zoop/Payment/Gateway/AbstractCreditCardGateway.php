<?php

namespace Zoop\Payment\Gateway;

use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Charge\CreditCardChargeInterface;
use Zoop\Payment\Refund\RefundInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractCreditCardGateway extends AbstractGateway implements
    CreditCardChargeInterface,
    RefundInterface
{
   
}
