<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment;

use \Exception;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\AP\SetPaymentOptionsResponse;
use PayPal\Types\AP\ReceiverOptions;
use PayPal\Types\AP\SetPaymentOptionsRequest;
use PayPal\Types\AP\RefundRequest;
use PayPal\Types\AP\DisplayOptions;
use PayPal\Types\AP\InvoiceData;
use PayPal\Types\AP\PayResponse;
use PayPal\Types\Common\ClientDetailsType;
use PayPal\Types\Common\FaultMessage;
use PayPal\Types\Common\ErrorData;
use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Gateway\GatewayInterface;
use Zoop\Payment\Gateway\GatewayResponseInterface;
use Zoop\Payment\Gateway\GatewayResponse;
use Zoop\Payment\Gateway\RedirectGatewayInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Gateway extends AbstractGateway implements
    GatewayInterface,
    RedirectGatewayInterface
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
     * 
     * @param type $amount
     * @param type $currency
     * @param OrderInterface $order
     * @return GatewayResponseInterface $response
     */
    public function charge($amount, $currency, OrderInterface $order)
    {
        $response = new GatewayResponse;
        try {
            $trackingId = $this->createTrackingId($order);

            $chargeResponse = $this->doCharge($amount, $currency, $trackingId, $order);

            if (is_array($chargeResponse->error) && count($chargeResponse->error) > 0) {
                $response->setError($this->formatErrors($chargeResponse->error));
                $response->setSuccess(false);
            } else {
                //apply the paypal payment options
//                $paymentOptions = $this->setPaymentOptions($chargeResponse->payKey, $order);
                $response->setSuccess(true);
            }
        } catch (Exception $ex) {
            $response->setSuccess(false);
            $response->setError($ex->getMessage());
        }

        return $response;
    }

    /**
     * 
     * @param type $amount
     * @param OrderInterface $order
     * @return GatewayResponseInterface $response
     */
    public function refund($amount, OrderInterface $order)
    {
        
    }

    /**
     * 
     * @param type $amount
     * @param type $currency
     * @param \Zoop\Order\DataModel\OrderInterface $order
     * @return GatewayResponseInterface $response
     */
    public function finalize($amount, $currency, OrderInterface $order)
    {
        
    }

    /**
     * 
     * @param double $amount
     * @param string $currency
     * @param OrderInterface $order
     * @return PayResponse
     * @throws APIException
     */
    protected function doCharge($amount, $currency, $trackingId, OrderInterface $order)
    {
        $requestEnvelope = new RequestEnvelope();
        $requestEnvelope->errorLanguage = $this->getErrorLanguage();

        $receivers = $this->getReceiverList($amount, $order);

        $payRequest = new PayRequest(
            $requestEnvelope,
            self::PAYMENT_TYPE_PAY,
            $this->getCancelUrl(),
            $currency,
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
        $optionsRequest->displayOptions->businessName = $this->getStore()->getName();

        //shipping details
        $orderDetails = $this->getOrderInterfaceDetails();
        if (!empty($orderDetails)) {
            $optionsRequest->senderOptions = new SenderOptions();

            $orderAddress = $order->getAddress();

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
