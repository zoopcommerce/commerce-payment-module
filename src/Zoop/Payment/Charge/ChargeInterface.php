<?php

namespace Zoop\Payment\Charge;

use Zoop\Payment\Charge\ChargeRequestInterface;
use Zoop\Payment\Charge\ChargeResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface ChargeInterface
{
    /**
     * @param ChargeRequestInterface $chargeRequest
     * @return ChargeResponse
     */
    public function charge(ChargeRequestInterface $chargeRequest);
}
