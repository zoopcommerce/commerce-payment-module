<?php

namespace Zoop\Payment\Charge;

use Zoop\Payment\DataModel\CreditCardInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class CreditCardChargeRequest extends AbstractChargeRequest implements
    ChargeRequestInterface,
    CreditCardChargeRequestInterface
{
    protected $creditCard;

    /**
     * @return CreditCardInterface
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }
    
    /**
     * @param CreditCardInterface $creditCard
     */
    public function setCreditCard(CreditCardInterface $creditCard)
    {
        $this->creditCard = $creditCard;
    }
}
