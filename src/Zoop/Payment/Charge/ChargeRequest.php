<?php

namespace Zoop\Payment\Charge;

use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Charge\ChargeRequestInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class ChargeRequest extends AbstractChargeRequest implements ChargeRequestInterface
{
    public function __construct($amount, OrderInterface $order)
    {
        $this->setAmount($amount);
        $this->setOrder($order);
    }
}
