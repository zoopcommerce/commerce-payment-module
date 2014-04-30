<?php

namespace Zoop\Payment\DataModel;

use Doctrine\Common\Collections\ArrayCollection;
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
 *     "Anz"                            = "Zoop\Payment\Gateway\Anz\DataModel\GatewayConfig",
 *     "CommonwealthBank"               = "Zoop\Payment\Gateway\CommonwealthBank\DataModel\GatewayConfig",
 *     "Free"                           = "Zoop\Payment\Gateway\Free\DataModel\GatewayConfig",
 *     "Paypal\ChainedPayment"          = "Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel\GatewayConfig",
 *     "Paypal\ExpressCheckout"         = "Zoop\Payment\Gateway\PayPal\ExpressCheckout\DataModel\GatewayConfig",
 *     "Pin"                            = "Zoop\Payment\Gateway\Pin\DataModel\GatewayConfig",
 *     "StGeorge"                       = "Zoop\Payment\Gateway\StGeorge\DataModel\GatewayConfig"
 * }) 
 */
abstract class AbstractGatewayConfig
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
     * @ODM\Collection
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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     * Adds a legacy id
     * 
     * @param int $legacyId
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = (int) $legacyId;
    }

    /**
     * @return ArrayCollection
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * @param ArrayCollection $stores
     */
    public function setStores(ArrayCollection $stores)
    {
        $this->stores = $stores;
    }

    /**
     * @param string $store
     */
    public function addStore($store)
    {
        $this->stores->add($store);
    }

    /**
     * The label to display to the customer in the checkout
     * 
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the label that the customer will see in
     * the checkout
     * 
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return ArrayCollection
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @param ArrayCollection $countries
     */
    public function setCountries(ArrayCollection $countries)
    {
        $this->countries = $countries;
    }

    /**
     * 2 letter country code
     * 
     * @param string $country
     */
    public function addCountry($country)
    {
        $this->countries->add($country);
    }

    /**
     * @return TransactionFee
     */
    public function getTransactionFee()
    {
        return $this->transactionFee;
    }

    /**
     * @param TransactionFee $transactionFee
     */
    public function setTransactionFee(TransactionFee $transactionFee)
    {
        $this->transactionFee = $transactionFee;
    }
}
