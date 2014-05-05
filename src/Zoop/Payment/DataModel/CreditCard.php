<?php

namespace Zoop\Payment\DataModel;

use Zoop\Payment\DataModel\CreditCardInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class CreditCard implements CreditCardInterface
{
    /**
     *
     * @ODM\String
     */
    protected $holder;

    /**
     *
     * @ODM\String
     */
    protected $number;

    /**
     *
     * @ODM\Int
     */
    protected $expiryMonth;

    /**
     *
     * @ODM\Int
     */
    protected $expiryYear;

    /**
     *
     * @ODM\String
     */
    protected $cvc;

    /**
     * 
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * 
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * 
     * @return int
     */
    public function getExpiryMonth()
    {
        return $this->expiryMonth;
    }

    /**
     * 
     * @return int
     */
    public function getExpiryYear()
    {
        return $this->expiryYear;
    }

    /**
     * 
     * @return string
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * 
     * @param string $holder
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;
    }

    /**
     * 
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * 
     * @param int $expiryMonth
     */
    public function setExpiryMonth($expiryMonth)
    {
        $this->expiryMonth = (int) $expiryMonth;
    }

    /**
     * 
     * @param int $expiryYear
     */
    public function setExpiryYear($expiryYear)
    {
        $this->expiryYear = (int) $expiryYear;
    }

    /**
     * 
     * @param string $cvc
     */
    public function setCvc($cvc)
    {
        $this->cvc = $cvc;
    }
}
