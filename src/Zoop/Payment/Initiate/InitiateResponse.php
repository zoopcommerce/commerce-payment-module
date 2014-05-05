<?php

namespace Zoop\Payment\Initiate;

use Zoop\Payment\DataModel\TransactionInterface;
use Zoop\Payment\AbstractResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class InitiateResponse extends AbstractResponse
{
    protected $transaction;
    protected $redirectUrl;

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
    
    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }
}
