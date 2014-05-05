<?php

namespace Zoop\Payment\Charge;

use Zoop\Payment\DataModel\CreditCardInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface CreditCardChargeRequestInterface
{
    /**
     * @return CreditCardInterface
     */
    public function getCreditCard();
    
    /**
     * @param CreditCardInterface $creditCard
     */
    public function setCreditCard(CreditCardInterface $creditCard);
}
