<?php

namespace Zoop\Payment\Provider\PayPalChainedPayment\DataModel;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Payment\DataModel\AbstractPromotion;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 */
class Payment extends AbstractPromotion
{

}
