<?php

return [
    'zoop' => [
        'payment' => [
            'gateways' => [
                'paypal.chainedpayment' => [
                    'config' => [
                        //below are sandbox credentials
                        'acct1.UserName' => 'dev-us-zoop_api1.zoopcommerce.com',
                        'acct1.Password' => '1364543052',
                        'acct1.Signature' => 'Auqmk6WOfK5MgQdka.87kFxacO-8A0FSyJ.r0wUXj6jfVMXU.zFtVQk1',
                        'acct1.AppId' => 'APP-80W284485P519543T',
                        'service.RedirectURL' => 'https://www.sandbox.paypal.com/webscr&cmd=',
                        'service.EndPoint.AdaptivePayments' => 'https://svcs.sandbox.paypal.com/',
                        'service.EndPoint.IPN' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
                        'http.ConnectionTimeOut' => '30',
                        'http.Retry' => '5',
                        'log.FileName' => 'PayPal.log',
                        'log.LogLevel' => 'Debug',
                        'log.LogEnabled' => 'false',
                    ],
                    'errorLanguage' => 'en_US',
                    'ipn_url' => 'http://ops.zoopcommerce.local/admin/payments/paypal/chainedpayments/ipn',
                    'primary_receiver' => 'dev-us-merchant@zoopcommerce.com',
                    'secondary_receivers' => [
                        'dev-us-merchant2@zoopcommerce.com'
                    ]
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
        ]
    ],
];
