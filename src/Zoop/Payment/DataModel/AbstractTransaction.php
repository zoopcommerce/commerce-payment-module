<?php

namespace Zoop\Payment\DataModel;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "Limited"         = "Zoop\Legacy\Promotion\DataModel\LimitedPromotion",
 *     "Unlimited"       = "Zoop\Legacy\Promotion\DataModel\UnlimitedPromotion"
 * })
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
abstract class AbstractTransaction
{
    use CreatedOnTrait;
    use UpdatedOnTrait;
}
