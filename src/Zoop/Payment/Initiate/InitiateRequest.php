<?php

namespace Zoop\Payment\Initiate;

use Zoop\Payment\Initiate\InitiateRequestInterface;
use Zoop\Order\DataModel\OrderInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class InitiateRequest extends AbstractInitiateRequest implements InitiateRequestInterface
{
    public function __construct($amount, OrderInterface $order)
    {
        $this->setAmount($amount);
        $this->setOrder($order);
    }
}
