<?php

namespace Zoop\Payment\Charge;

use Zoop\Payment\Charge\CreditCardChargeRequestInterface;
use Zoop\Payment\Charge\ChargeResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface CreditCardChargeInterface
{
    /**
     * @param CreditCardChargeRequestInterface $chargeRequest
     * @return ChargeResponse
     */
    public function charge(CreditCardChargeRequestInterface $chargeRequest);
}
