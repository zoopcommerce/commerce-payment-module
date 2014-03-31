<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel;

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
     * @ODM\String
     * @Shard\Validator\Chain({
     *     @Shard\Validator\Required,
     *     @Shard\Validator\Email
     * })
     */
    protected $primaryReceiver;

    /**
     *
     * @ODM\String
     */
    protected $token;

    /**
     *
     * @ODM\String
     */
    protected $code;

    /**
     *
     * @ODM\Boolean
     */
    protected $sandbox = false;

    /**
     *
     * @ODM\Boolean
     */
    protected $verified = false;

    public function getPrimaryReceiver()
    {
        return $this->primaryReceiver;
    }

    public function setPrimaryReceiver($primaryReceiver)
    {
        $this->primaryReceiver = $primaryReceiver;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getSandbox()
    {
        return $this->sandbox;
    }

    public function setSandbox($sandbox)
    {
        $this->sandbox = (boolean) $sandbox;
    }

    public function getVerified()
    {
        return $this->verified;
    }

    public function setVerified($verified)
    {
        $this->verified = (boolean) $verified;
    }

}
