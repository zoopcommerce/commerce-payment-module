<?php

namespace Zoop\Payment\DataModel;

interface CreditCardInterface
{
    /**
     * @return string
     */
    public function getHolder();
    
    /**
     * @return string
     */
    public function getNumber();
    
    /**
     * @return int
     */
    public function getExpiryMonth();

    /**
     * @return int
     */
    public function getExpiryYear();

    /**
     * @return string
     */
    public function getCvc();
}
