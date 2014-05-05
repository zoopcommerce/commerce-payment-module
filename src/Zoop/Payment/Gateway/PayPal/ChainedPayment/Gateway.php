<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment;

use \Exception;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\AP\SetPaymentOptionsResponse;
use PayPal\Types\AP\SenderOptions;
use PayPal\Types\AP\ShippingAddressInfo;
use PayPal\Types\AP\SetPaymentOptionsRequest;
use PayPal\Types\AP\DisplayOptions;
use PayPal\Types\AP\PayResponse;
use PayPal\Types\Common\ClientDetailsType;
use PayPal\Types\Common\ErrorData;
use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel\Transaction;
use Zoop\Payment\Gateway\AbstractRedirectGateway;
use Zoop\Payment\Charge\ChargeRequestInterface;
use Zoop\Payment\Charge\ChargeResponse;
use Zoop\Payment\Initiate\InitiateRequestInterface;
use Zoop\Payment\Initiate\InitiateResponse;
use Zoop\Payment\Refund\RefundRequestInterface;
use Zoop\Payment\Refund\RefundResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Gateway extends AbstractRedirectGateway
{
    const FEE_PRIMARY = 'PRIMARYRECEIVER';
    const FEE_EACH = 'EACHRECEIVER';
    const FEE_SECONDARY = 'SECONDARYONLY';
    const PAYMENT_TYPE_PAY = 'PAY';
    const PAYMENT_TYPE_CREATE = 'CREATE';
    const PAYMENT_TYPE_REFUND = 'REFUND';

    protected $config;
    protected $cancelUrl;
    protected $returnUrl;
    protected $ipnUrl;
    protected $headerImage;
    protected $store;
    protected $primaryReceiver;
    protected $secondaryReceivers = [];
    protected $errorLanguage = 'en_US';

    /**
     * Initiates a redirect request
     * 
     * @param InitiateRequestInterface $initiateRequest
     * @return InitiateResponse
     */
    public function initiate(InitiateRequestInterface $initiateRequest)
    {
        $response = new InitiateResponse;
        try {
            $order = $initiateRequest->getOrder();
            $amount = $initiateRequest->getAmount();

            $trackingId = $this->createTrackingId($order);
            
            //execute the paypal request
            $paypalResponse = $this->doInitiate(
                $amount,
                $trackingId,
                $order
            );

            if (is_array($paypalResponse->error) && count($paypalResponse->error) > 0) {
                $response->setError($this->formatErrors($paypalResponse->error));
                $response->setSuccess(false);
            } else {
                $response->setSuccess(true);

                //apply the paypal payment options
                $this->setPaymentOptions($paypalResponse->payKey, $order);

                //update the transaction details
                $transaction = $this->createTransaction($amount, $paypalResponse->payKey);
                $response->setTransaction($transaction);
            }
        } catch (Exception $ex) {
            $response->setSuccess(false);
            $response->setError($ex->getMessage());
        }

        return $response;
    }

    /**
     * Charges an account
     * 
     * @param ChargeRequestInterface $chargeRequest
     * @return ChargeResponse
     */
    public function charge(ChargeRequestInterface $chargeRequest)
    {
        
    }

    /**
     * @param RefundRequest $chargeRequest
     * @return RefundResponse
     */
    public function refund(RefundRequestInterface $chargeRequest)
    {
        
    }

    /**
     * @param float $amount
     * @param string $payKey
     */
    protected function createTransaction($amount, $payKey)
    {
        $transaction = new Transaction;
        $transaction->setAmount($amount);
        $transaction->setPayKey($payKey);

        return $transaction;
    }

    /**
     * 
     * @param double $amount
     * @param string $trackingId
     * @param OrderInterface $order
     * @return PayResponse
     * @throws APIException
     */
    protected function doInitiate($amount, $trackingId, OrderInterface $order)
    {
        $requestEnvelope = new RequestEnvelope();
        $requestEnvelope->errorLanguage = $this->getErrorLanguage();

        $receivers = $this->getReceiverList($amount, $order);

        $payRequest = new PayRequest(
            $requestEnvelope,
            self::PAYMENT_TYPE_PAY,
            $this->getCancelUrl(),
            $order->getTotal()->getCurrency()->getCode(),
            $receivers,
            $this->getReturnUrl()
        );
        
        $payRequest->trackingId = $trackingId;
        $payRequest->feesPayer = (count($receivers->receiver) > 1) ? self::FEE_PRIMARY : self::FEE_EACH;
        $payRequest->ipnNotificationUrl = $this->getIpnUrl();
        $payRequest->reverseAllParallelPaymentsOnError = true;
        $payRequest->memo = 'OrderInterface ID: ' . $order->getId();

        //client details
        $clientDetails = new ClientDetailsType();
        $clientDetails->ipAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $payRequest->clientDetails = $clientDetails;

        $adaptivePayment = new AdaptivePaymentsService($this->getConfig());

        return $adaptivePayment->Pay($payRequest);
    }

    /**
     * Creates the PayPal receivers list.
     * 
     * @param double $amount
     * @param OrderInterface $order
     * @return ReceiverList
     */
    protected function getReceiverList($amount, OrderInterface $order)
    {
        $receivers = [];

        //secondary
        foreach ($this->getSecondaryReceivers() as $payeeEmail) {
            $receiver = new Receiver();
            $receiver->email = $payeeEmail;
            $receiver->amount = $order->getCommission()->getCharged();
            $receiver->primary = false;

            // add reciever to pay request
            $receivers[] = $receiver;
        }

        //primary
        $receiver = new Receiver();
        $receiver->email = $this->getPrimaryReceiver();
        $receiver->amount = $amount;
        $receiver->primary = !empty($receivers);

        // add main reciever to pay request
        $receivers[] = $receiver;

        return new ReceiverList($receivers);
    }

    /**
     * 
     * @param string $paykey
     * @param string $trackingId
     * @param OrderInterface $order
     * @return SetPaymentOptionsResponse
     */
    protected function setPaymentOptions($paykey, OrderInterface $order)
    {
        $requestEnv = new RequestEnvelope();
        $requestEnv->errorLanguage = $this->getErrorLanguage();

        $optionsRequest = new SetPaymentOptionsRequest($requestEnv);
        $optionsRequest->payKey = $paykey;

        // general page display data
        $optionsRequest->displayOptions = new DisplayOptions();

        // header image
        $headerImage = $this->getHeaderImage();
        if (!empty($headerImage)) {
            $optionsRequest->displayOptions->headerImageUrl = $headerImage;
        }

        // business name
//        $optionsRequest->displayOptions->businessName = $this->getStore()->getName();
        //shipping details
        $optionsRequest->senderOptions = new SenderOptions();

        $orderAddress = $order->getAddress();

        if (!empty($orderAddress)) {
            $shippingAddress = new ShippingAddressInfo();
            $shippingAddress->addresseeName = $order->getFullName();
            $shippingAddress->street1 = $orderAddress->getLine1();
            $shippingAddress->street2 = $orderAddress->getLine2();
            $shippingAddress->city = $orderAddress->getCity();
            $shippingAddress->state = $orderAddress->getState();
            $shippingAddress->zip = $orderAddress->getPostcode();
            $shippingAddress->country = $orderAddress->getCountry();

            $optionsRequest->senderOptions->shippingAddress = $shippingAddress;
        }

        $service = new AdaptivePaymentsService($this->getConfig());

        return $service->SetPaymentOptions($optionsRequest);
    }

    /**
     * 
     * @return string
     */
    public function getPrimaryReceiver()
    {
        return $this->primaryReceiver;
    }

    /**
     * 
     * @param string $primaryReceiver
     */
    public function setPrimaryReceiver($primaryReceiver)
    {
        $this->primaryReceiver = $primaryReceiver;
    }

    /**
     * 
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * 
     * @return string
     */
    public function getIpnUrl()
    {
        return $this->ipnUrl;
    }

    /**
     * 
     * @param string $ipnUrl
     */
    public function setIpnUrl($ipnUrl)
    {
        $this->ipnUrl = $ipnUrl;
    }

    /**
     * 
     * @return array
     */
    public function getSecondaryReceivers()
    {
        return $this->secondaryReceivers;
    }

    /**
     * 
     * @param array $secondaryReceivers
     */
    public function setSecondaryReceivers(array $secondaryReceivers)
    {
        $this->secondaryReceivers = $secondaryReceivers;
    }

    /**
     * 
     * @return string
     */
    public function getErrorLanguage()
    {
        return $this->errorLanguage;
    }

    /**
     * 
     * @param string $errorLanguage
     */
    public function setErrorLanguage($errorLanguage)
    {
        $this->errorLanguage = $errorLanguage;
    }

    /**
     * 
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * 
     * @param string $cancelUrl
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;
    }

    /**
     * 
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * 
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * The header image to display on PayPal
     * It's best if the dimensions are 750px X 90px
     * 
     * @return string
     */
    public function getHeaderImage()
    {
        return $this->headerImage;
    }

    /**
     * 
     * @param string $headerImage
     */
    public function setHeaderImage($headerImage)
    {
        $this->headerImage = $headerImage;
    }

    protected function formatErrors($rawErrors)
    {
        //errors
        $errors = [];
        /* @var $error ErrorData */
        foreach ($rawErrors as $error) {
            $errors[] = $error->message;
        }
        return implode('. ', $errors);
    }
}
