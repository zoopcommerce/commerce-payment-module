<?php

namespace Zoop\Payment\Gateway\StGeorge\DataModel;

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
    protected $gatewayId;

    /**
     *
     * @ODM\Boolean
     */
    protected $sandbox = false;

    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    public function setGatewayId($gatewayId)
    {
        $this->gatewayId = $gatewayId;
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
