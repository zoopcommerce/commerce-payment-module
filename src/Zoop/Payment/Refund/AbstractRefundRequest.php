<?php

namespace Zoop\Payment\Refund;

use Zoop\Order\DataModel\OrderInterface;
/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractRefundRequest
{
    protected $amount;
    protected $order;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;
    }

    /**
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }
}
