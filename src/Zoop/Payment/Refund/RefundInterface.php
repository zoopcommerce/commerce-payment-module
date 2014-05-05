<?php

namespace Zoop\Payment\Refund;

use Zoop\Payment\Refund\RefundRequestInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface RefundInterface
{
    /**
     * @param RefundRequest $chargeRequest
     * @return RefundResponse
     */
    public function refund(RefundRequestInterface $chargeRequest);
}
