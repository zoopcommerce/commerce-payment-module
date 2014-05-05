<?php

namespace Zoop\Payment;

use Zoop\Payment\AbstractResponseInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
abstract class AbstractResponse implements AbstractResponseInterface
{
    protected $success;
    protected $error;

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
