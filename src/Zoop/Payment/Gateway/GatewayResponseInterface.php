<?php

namespace Zoop\Payment\Gateway;

use Zoop\Payment\DataModel\TransactionInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface GatewayResponseInterface
{
    /**
     * @return TransactionInterface The transaction details
     */
    public function getTransaction();
    
    /**
     * @return boolean If the transaction was successful
     */
    public function isSuccess();
    
    /**
     * @return string|null The error message if not successful
     */
    public function getError();
}
