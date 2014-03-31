<?php

namespace Zoop\Payment\Paypal\Common;

trait PaypalConfigTrait
{
    public function compileConfig($paypalConfig)
    {
        return [
            'mode' => $paypalConfig['mode'],
            'acct1.UserName' => $paypalConfig['username'],
            'acct1.Password' => $paypalConfig['password'],
            'acct1.Signature' => $paypalConfig['signature'],
            'acct1.AppId' => $paypalConfig['application_id'],
//            'service.RedirectURL' => $redirect,
//            'service.EndPoint.PayPalAPI' => $paypalConfig['endpoint']['service'],
//            'service.EndPoint.PayPalAPIAA' => $paypalConfig['endpoint']['service'],
//            'service.EndPoint.AdaptivePayments' => $paypalConfig['endpoint']['service'],
//            'service.EndPoint.AdaptiveAccounts' => $paypalConfig['endpoint']['service'],
//            'service.EndPoint.Permissions' => $paypalConfig['endpoint']['service'],
//            'service.EndPoint.IPN' => $paypalConfig['endpoint']['ipn'],
            'http.ConnectionTimeOut' => '30',
            'http.Retry' => '5',
            //'http.TrustAllConnection' => 1,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'Debug',
            'log.LogEnabled' => 'false'
        ];
    }
}