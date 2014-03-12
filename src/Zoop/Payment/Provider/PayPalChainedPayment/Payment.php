<?php

namespace Zoop\Payment\Provider\PayPalChainedPayment;

use Zoop\Payment\Provider\AbstractProvider;
use Zoop\Payment\Provider\ProviderInterface;
use Zoop\Payment\Provider\RedirectProviderInterface;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\AP\ReceiverOptions;
use PayPal\Types\AP\SenderOptions;
use PayPal\Types\AP\ShippingAddressInfo;
use PayPal\Types\AP\SetPaymentOptionsRequest;
use PayPal\Types\AP\RefundRequest;
use PayPal\Types\AP\DisplayOptions;
use PayPal\Types\AP\InvoiceData;
use PayPal\Types\Common\ClientDetailsType;
use PayPal\Types\Common\FaultMessage;
use PayPal\Types\Common\ErrorData;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Payment extends AbstractProvider implements ProviderInterface, RedirectProviderInterface
{
    public function charge($amount, $currency)
    {

    }

    public function redirect($amount, $currency)
    {

    }

    public function refund($amount = 0)
    {

    }
}
