<?php

namespace Zoop\Payment\Gateway\Free\DataModel;

use Zoop\Payment\DataModel\AbstractGatewayConfig;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 */
class GatewayConfig extends AbstractGatewayConfig
{
    
}
