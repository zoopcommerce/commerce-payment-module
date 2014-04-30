<?php

namespace Zoop\Payment\Gateway\Anz\DataModel;

use Zoop\Payment\DataModel\AbstractGatewayConfig;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 */
class GatewayConfig extends AbstractGatewayConfig
{
    /**
     *
     * @ODM\String
     */
    protected $merchantProfileId;

    /**
     *
     * @ODM\String
     */
    protected $accessCode;

    /**
     *
     * @ODM\String
     */
    protected $secureHash;

    /**
     *
     * @ODM\String
     */
    protected $username;

    /**
     * @ODM\String
     * @Shard\Crypt\BlockCipher(
     *     key = "crypt.payment.password",
     *     salt = "crypt.payment.password"
     * )
     */
    protected $password;

    public function getMerchantProfileId()
    {
        return $this->merchantProfileId;
    }

    public function setMerchantProfileId($merchantProfileId)
    {
        $this->merchantProfileId = $merchantProfileId;
    }

    public function getAccessCode()
    {
        return $this->accessCode;
    }

    public function setAccessCode($accessCode)
    {
        $this->accessCode = $accessCode;
    }

    public function getSecureHash()
    {
        return $this->secureHash;
    }

    public function setSecureHash($secureHash)
    {
        $this->secureHash = $secureHash;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
