<?php

namespace Zoop\Payment\Gateway\PayPal\ExpressCheckout\DataModel;

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
     * @ODM\String
     * @Shard\Validator\Chain({
     *     @Shard\Validator\Required,
     *     @Shard\Validator\Email
     * })
     */
    protected $primaryReceiver;

    /**
     *
     * @ODM\Boolean
     */
    protected $sandbox = false;

    public function getPrimaryReceiver()
    {
        return $this->primaryReceiver;
    }

    public function setPrimaryReceiver($primaryReceiver)
    {
        $this->primaryReceiver = $primaryReceiver;
    }

    public function getSandbox()
    {
        return $this->sandbox;
    }

    public function setSandbox($sandbox)
    {
        $this->sandbox = $sandbox;
    }
}
