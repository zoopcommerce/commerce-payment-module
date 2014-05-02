<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel;

use Zoop\Payment\DataModel\AbstractTransaction;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 */
class Transaction extends AbstractTransaction
{
    use CreatedOnTrait;
    use UpdatedOnTrait;

    protected $payKey;
    protected $transactionId;
    protected $senderEmail;

    public function getPayKey()
    {
        return $this->payKey;
    }

    public function setPayKey($payKey)
    {
        $this->payKey = $payKey;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
