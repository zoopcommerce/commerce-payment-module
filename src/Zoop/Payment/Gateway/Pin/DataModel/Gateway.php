<?php

namespace Zoop\Payment\Gateway\Pin\DataModel;

use Zoop\Payment\DataModel\AbstractPaymentGateway;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 */
class Gateway extends AbstractPaymentGateway
{
    /**
     *
     * @ODM\String
     */
    protected $apiKey;

    /**
     * @ODM\String
     * @Shard\Crypt\BlockCipher(
     *     key = "crypt.payment.password",
     *     salt = "crypt.payment.password"
     * )
     */
    protected $apiSecret;

    /**
     *
     * @ODM\Boolean
     */
    protected $sandbox = false;

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    public function getSandbox()
    {
        return $this->sandbox;
    }

    public function setSandbox($sandbox)
    {
        $this->sandbox = (boolean) $sandbox;
    }
}
