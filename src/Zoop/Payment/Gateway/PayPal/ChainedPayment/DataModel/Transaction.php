<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel;

use Zoop\Payment\DataModel\AbstractTransaction;
use Zoop\Payment\DataModel\TransactionInterface;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 */
class Transaction extends AbstractTransaction implements TransactionInterface
{
    use CreatedOnTrait;
    use UpdatedOnTrait;

    /**
     *
     * @ODM\String
     */
    protected $payKey;

    /**
     *
     * @ODM\String
     */
    protected $transactionId;

    /**
     *
     * @ODM\String
     */
    protected $senderEmail;

    /**
     * 
     * @return string
     */
    public function getPayKey()
    {
        return $this->payKey;
    }

    /**
     * 
     * @param string $payKey
     */
    public function setPayKey($payKey)
    {
        $this->payKey = $payKey;
    }

    /**
     * 
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * 
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * 
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * 
     * @param string $senderEmail
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }
}
