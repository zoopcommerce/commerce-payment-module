<?php

namespace Zoop\Payment\Charge;

use Zoop\Payment\DataModel\TransactionInterface;
use Zoop\Payment\AbstractResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class ChargeResponse extends AbstractResponse
{
    protected $transaction;

    /**
     * @return TransactionInterface
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param TransactionInterface $transaction
     */
    public function setTransaction(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }
}
