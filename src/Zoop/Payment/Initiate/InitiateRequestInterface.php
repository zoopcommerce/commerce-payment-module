<?php

namespace Zoop\Payment\Initiate;

use Zoop\Order\DataModel\OrderInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface InitiateRequestInterface
{
    /**
     * @return float
     */
    public function getAmount();

    /**
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * @param float $amount
     */
    public function setAmount($amount);

    /**
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order);
}
