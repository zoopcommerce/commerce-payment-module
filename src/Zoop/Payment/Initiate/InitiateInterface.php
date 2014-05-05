<?php

namespace Zoop\Payment\Initiate;

use Zoop\Payment\Initiate\InitiateRequestInterface;
use Zoop\Payment\Initiate\InitiateResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
interface InitiateInterface
{
    /**
     * @param InitiateRequest $initiateRequest
     * @return InitiateResponse
     */
    public function initiate(InitiateRequestInterface $initiateRequest);
}
