<?php

namespace Zoop\Payment;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface AbstractResponseInterface
{    
    /**
     * @return boolean If the transaction was successful
     */
    public function isSuccess();
    
    /**
     * @return string|null The error message if not successful
     */
    public function getError();
}
