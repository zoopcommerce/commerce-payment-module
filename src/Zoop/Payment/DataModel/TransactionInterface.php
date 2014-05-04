<?php

namespace Zoop\Payment\DataModel;

interface TransactionInterface
{
    /**
     * @return boolean If the transaction is complete
     */
    public function isComplete();

    /**
     * @return double Transaction amount
     */
    public function getAmount();
}
