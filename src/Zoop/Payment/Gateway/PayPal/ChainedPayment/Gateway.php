<?php

namespace Zoop\Payment\Gateway\PayPal\ChainedPayment;

use \Exception;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\AP\ReceiverOptions;
use PayPal\Types\AP\SetPaymentOptionsRequest;
use PayPal\Types\AP\RefundRequest;
use PayPal\Types\AP\DisplayOptions;
use PayPal\Types\AP\InvoiceData;
use PayPal\Types\AP\PayResponse;
use PayPal\Types\Common\ClientDetailsType;
use PayPal\Types\Common\FaultMessage;
use PayPal\Types\Common\ErrorData;
use Zoop\Order\DataModel\Order;
use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Gateway\GatewayInterface;
use Zoop\Payment\Gateway\GatewayModelInterface;
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
    protected $primaryReceiver;
    protected $secondaryReceivers = [];
    protected $errorLanguage = 'en_US';

    public function charge($amount, $currency, Order $order)
    {
        try {
            $response = $this->doCharge($amount, $currency, $order);
        } catch (Exception $ex) {
            
        }
    }

    public function redirect($amount, $currency, Order $order)
    {
        
    }

    public function refund($amount, Order $order)
    {
        
    }

    /**
     * 
     * @param double $amount
     * @param string $currency
     * @param Order $order
     * @return PayResponse
     * @throws APIException
     */
    protected function doCharge($amount, $currency, Order $order)
    {
        $requestEnvelope = new RequestEnvelope();
        $requestEnvelope->errorLanguage = $this->error_language;

        $payRequest = new PayRequest(
                $requestEnvelope, self::PAYMENT_TYPE_PAY, $this->getCancelUrl(), $currency, $this->getReturnUrl()
        );
        $payRequest->ipnNotificationUrl = $this->getIpnUrl();
        $payRequest->reverseAllParallelPaymentsOnError = true;
        $payRequest->memo = 'Order ID: ' . $order->getId();

        //client details
        $clientDetails = new ClientDetailsType();
        $clientDetails->ipAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

        $payRequest->clientDetails = $clientDetails;
        $payRequest->receiverList = $this->getReceiverList($amount, $order);

        $adaptivePayment = new AdaptivePaymentsService($this->getConfig());
        return $adaptivePayment->Pay($payRequest);
    }

    protected function getReceiverList($amount, Order $order)
    {
        $receivers = [];

        //primary
        $receiver = new Receiver();
        $receiver->email = $this->getPrimaryReceiver();
        $receiver->amount = $amount;
        $receiver->primary = true;

        // add reciever to pay request
        $receivers[] = $receiver;

        //secondary
        foreach ($this->getSecondaryReceivers() as $payee) {
            $receiver = new Receiver();
            $receiver->email = $payee;
//            $receiver->amount = $order->getCommission()->getPaid();
            $receiver->primary = false;

            // add reciever to pay request
            $receivers[] = $receiver;
        }

        return new ReceiverList($receivers);
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
}
