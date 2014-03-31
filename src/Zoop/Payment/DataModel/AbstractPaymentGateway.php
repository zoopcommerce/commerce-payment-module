<?php

namespace Zoop\Payment\DataModel;

use Doctrine\Common\Collections\ArrayCollection;
use Zoop\Api\DataModel\Country;
use Zoop\Shard\Stamp\DataModel\CreatedOnTrait;
use Zoop\Shard\Stamp\DataModel\CreatedByTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedOnTrait;
use Zoop\Shard\Stamp\DataModel\UpdatedByTrait;
use Zoop\Shard\SoftDelete\DataModel\SoftDeleteableTrait;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\Document(collection="PaymentGateway")
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField(fieldName="type")
 * @ODM\DiscriminatorMap({
 *     "AnzEgate"                       = "AnzEgate"
 *     "CommbankCommWeb"                = "CommbankCommWeb",
 *     "PaypalChainedPayment"           = "PaypalChainedPayment",
 *     "PaypalExpressCheckout"          = "PaypalExpressCheckout",
 *     "Pin"                            = "Pin",
 *     "StGeorgeInternetPaymentGateway" = "StGeorgeInternetPaymentGateway"
 * }) 
 */
abstract class AbstractPaymentGateway
{
    use CreatedOnTrait;
    use CreatedByTrait;
    use UpdatedOnTrait;
    use UpdatedByTrait;
    use SoftDeleteableTrait;

    /**
     * @ODM\Id(strategy="UUID")
     */
    protected $id;

    /**
     *
     * @ODM\Int
     */
    protected $legacyId;

    /**
     * Array. Stores that this product is part of.
     * The Zones annotation means this field is used by the Zones filter so
     * only products from the active store are available.
     *
     * @ODM\Collection
     * @Shard\Zones
     * @Shard\Validator\Required
     */
    protected $stores;

    /**
     *
     * @ODM\String
     */
    protected $label;

    /**
     *
     * @ODM\ReferenceMany(targetDocument="Zoop\Api\DataModel\Country", simple="true")
     */
    protected $countries;

    /**
     *
     * @ODM\EmbedOne(targetDocument="TransactionFee")
     */
    protected $transactionFee;

    public function __construct()
    {
        $this->stores = new ArrayCollection();
        $this->countries = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLegacyId()
    {
        return $this->legacyId;
    }

    public function setLegacyId($legacyId)
    {
        $this->legacyId = $legacyId;
    }

    public function getStores()
    {
        return $this->stores;
    }

    public function setStores($stores)
    {
        $this->stores = $stores;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getCountries()
    {
        return $this->countries;
    }

    public function setCountries($countries)
    {
        $this->countries = $countries;
    }

    public function addCountry(Country $country)
    {
        $this->countries->add($country);
    }

    public function getTransactionFee()
    {
        return $this->transactionFee;
    }

    public function setTransactionFee(TransactionFee $transactionFee)
    {
        $this->transactionFee = $transactionFee;
    }
}
