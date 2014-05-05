<?php

namespace Zoop\Payment\Gateway\Anz;

use \Exception;
use Zoop\Payment\Gateway\AbstractCreditCardGateway;
use Zoop\Payment\Charge\ChargeRequestInterface;
use Zoop\Payment\Charge\ChargeResponse;
use Zoop\Payment\Refund\RefundRequestInterface;
use Zoop\Payment\Refund\RefundResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Gateway extends AbstractCreditCardGateway
{
    protected $server;
    protected $port;
    protected $merchantProfileId;
    protected $accessCode;
    protected $secureHash;
    protected $username;
    protected $password;

    /**
     * Charges an account
     * 
     * @param ChargeRequestInterface $chargeRequest
     * @return ChargeResponse
     */
    public function charge(ChargeRequestInterface $chargeRequest)
    {
        
    }

    /**
     * Refunds a specific amount from a particular transaction
     * 
     * @param RefundRequest $chargeRequest
     * @return RefundResponse
     */
    public function refund(RefundRequestInterface $chargeRequest)
    {
        
    }

    /**
     * 
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * 
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * 
     * @return string
     */
    public function getMerchantProfileId()
    {
        return $this->merchantProfileId;
    }

    /**
     * 
     * @return string
     */
    public function getAccessCode()
    {
        return $this->accessCode;
    }

    /**
     * 
     * @return string
     */
    public function getSecureHash()
    {
        return $this->secureHash;
    }

    /**
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * 
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * 
     * @param string $merchantProfileId
     */
    public function setMerchantProfileId($merchantProfileId)
    {
        $this->merchantProfileId = $merchantProfileId;
    }

    /**
     * 
     * @param string $accessCode
     */
    public function setAccessCode($accessCode)
    {
        $this->accessCode = $accessCode;
    }

    /**
     * 
     * @param string $secureHash
     */
    public function setSecureHash($secureHash)
    {
        $this->secureHash = $secureHash;
    }

    /**
     * 
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * 
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
