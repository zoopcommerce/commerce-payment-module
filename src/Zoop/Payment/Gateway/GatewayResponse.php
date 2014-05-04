<?php

namespace Zoop\Payment\Gateway;

use Zoop\Payment\DataModel\TransactionInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
use Zoop\Payment\Gateway\GatewayResponseInterface;

class GatewayResponse implements GatewayResponseInterface
{
    protected $transaction;
    protected $success;
    protected $error;

    /**
     * The transaction model
     * 
     * @return TransactionInterface
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Is the transaction a success
     * 
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->getSuccess();
    }

    /**
     * Alias getter function for isSuccess()
     *  
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * The error message if isSuccess() === false
     * 
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 
     * @param TransactionInterface $transaction
     */
    public function setTransaction(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * 
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = (boolean) $success;
    }

    /**
     * 
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}
