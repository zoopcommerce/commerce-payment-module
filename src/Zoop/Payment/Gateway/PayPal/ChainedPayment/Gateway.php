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
use PayPal\Types\Common\ClientDetailsType;
use PayPal\Types\Common\FaultMessage;
use PayPal\Types\Common\ErrorData;
use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Gateway\GatewayInterface;
use Zoop\Payment\Gateway\GatewayModelInterface;
use Zoop\Payment\Gateway\RedirectGatewayInterface;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Gateway extends AbstractGateway implements
GatewayInterface, RedirectGatewayInterface
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

    public function charge($amount, $currency)
    {
        
    }

    public function redirect($amount, $currency)
    {
        
    }

    public function refund($amount = 0)
    {
        
    }

    protected function doCharge()
    {
        $payRequest = new PayRequest();
        $payRequest->actionType = self::PAYMENT_TYPE_PAY;
        $payRequest->cancelUrl = $this->getCancelUrl();
        $payRequest->ipnNotificationUrl = $this->getIpnUrl();
        $payRequest->returnUrl = $this->getReturnUrl();
//        $payRequest->trackingId = $tracking_id;
        $payRequest->clientDetails = new ClientDetailsType();
        $payRequest->clientDetails->applicationId = $this->getApplicationId();
        $payRequest->clientDetails->deviceId = $this->device_id;
        $payRequest->clientDetails->ipAddress = $_SERVER['REMOTE_ADDR'];
        $payRequest->currencyCode = $currency;
        $payRequest->reverseAllParallelPaymentsOnError = true;
        if (!empty($this->payment_memo)) {
            $payRequest->memo = $this->payment_memo;
        }
        $payRequest->feesPayer = $this->payee_fee_method;

        // set the payer
        if (!empty($this->payer)) {
            $payRequest->senderEmail = $this->payer['email'];
        }

        $payRequest->requestEnvelope = new RequestEnvelope();
        $payRequest->requestEnvelope->errorLanguage = $this->error_language;
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
