<?php

namespace Zoop\Payment\Gateway\Anz\DataModel;

use Zoop\Payment\DataModel\AbstractTransaction;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document
 */
class Transaction extends AbstractTransaction
{
    
}
