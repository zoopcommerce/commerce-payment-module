<?php

namespace Zoop\Payment\DataModel;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "Anz"                            = "Zoop\Payment\Gateway\Anz\DataModel\Transaction",
 *     "CommonwealthBank"               = "Zoop\Payment\Gateway\CommonwealthBank\DataModel\Transaction",
 *     "Free"                           = "Zoop\Payment\Gateway\Free\DataModel\Transaction",
 *     "PaypalChainedPayment"           = "Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel\Transaction",
 *     "PaypalExpressCheckout"          = "Zoop\Payment\Gateway\PayPal\PaypalExpressCheckout\DataModel\Transaction",
 *     "Pin"                            = "Zoop\Payment\Gateway\Pin\DataModel\Transaction",
 *     "StGeorge"                       = "Zoop\Payment\Gateway\StGeorge\DataModel\Transaction"
 * })
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
abstract class AbstractTransaction
{
    use CreatedOnTrait;
    use UpdatedOnTrait;

    /**
     *
     * @ODM\Boolean
     */
    protected $isComplete;

    /**
     *
     * @ODM\Float
     */
    protected $amount;

    /**
     * 
     * @return boolean
     */
    public function isComplete()
    {
        return $this->getIsComplete();
    }

    /**
     * 
     * @return boolean
     */
    public function getIsComplete()
    {
        return $this->isComplete;
    }

    /**
     * 
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * 
     * @param boolean $isComplete
     */
    public function setIsComplete($isComplete)
    {
        $this->isComplete = (boolean) $isComplete;
    }

    /**
     * 
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;
    }
}
