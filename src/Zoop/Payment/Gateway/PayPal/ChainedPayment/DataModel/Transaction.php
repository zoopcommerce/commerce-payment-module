<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Payment\DataModel\AbstractTransaction;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 */
class Transaction extends AbstractTransaction
{

}
