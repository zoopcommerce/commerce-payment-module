<?php

return [
    'zoop' => [
        'payment' => [
            'gateways' => [
                'paypal.chainedpayment' => [
                    'config' => [
                        //below are sandbox credentials
                        'acct1.UserName' => 'paypal_api1.completepurchase.com',
                        'acct1.Password' => 'YKXU2YBEZLZ29QS5',
                        'acct1.Signature' => 'ABqcw6xTAKvmsdu-80HQn8X9G2EGA28NksV.zNJQpAMWEgjekSNdsE6.',
                        'acct1.AppId' => 'APP-28903957F1859293N',
                        'service.RedirectURL' => 'https://www.paypal.com/webscr&cmd=',
                        'service.EndPoint.AdaptivePayments' => 'https://svcs.paypal.com/',
                        'service.EndPoint.IPN' => 'https://ipnpb.paypal.com/cgi-bin/webscr',
                        'http.ConnectionTimeOut' => '30',
                        'http.Retry' => '5',
                        'log.FileName' => 'PayPal.log',
                        'log.LogLevel' => 'Debug',
                        'log.LogEnabled' => 'false',
                    ],
                    'errorLanguage' => 'en_US',
                    'ipn_url' => 'http://ops.zoopcommerce.com/admin/payments/paypal/chainedpayments/ipn',
                    'primary_receiver' => null,
                    'secondary_receivers' => [] //'paypal@zoopcommerce.com'
                ],
                'anz' => [
                    'server' => 'https://migs.mastercard.com.au/vpcdps'
                ]
            ]
        ],
        'shard' => [
            'manifest' => [
                'commerce' => [
                    'models' => [
                        'Zoop\Payment\DataModel' => __DIR__ . '/../src/Zoop/Payment/DataModel',
                        'Zoop\Payment\Gateway\PayPal\ChainedPayment\DataModel' => __DIR__ . '/../src/Zoop/Payment/Gateway/PayPal/ChainedPayment/DataModel',
                    ]
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
        ],
    ],
    'view_manager' => [
        'strategies' => [
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
//            'Zoop\Payment\Gateway\Service\AbstractGatewayFactory' //zoop.payment.gateway.{gateway_name}
        ],
        'factories' => [
            'zoop.commerce.payment.gateway.paypal.chainedpayment' => 'Zoop\Payment\Gateway\PayPal\ChainedPayment\GatewayFactory',
            'zoop.commerce.payment.gateway.paypal.expresscheckout' => 'Zoop\Payment\Gateway\PayPal\ExpressCheckout\GatewayFactory',
            'zoop.commerce.payment.gateway.anz' => 'Zoop\Payment\Gateway\Anz\GatewayFactory',
        ]
    ],
];
