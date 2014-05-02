<?php

$mongoConnectionString = 'mongodb://localhost:27017';
$mongoZoopDatabase = 'zoop_test';
$mysqlZoopDatabase = 'zoop_test';

return [
    'doctrine' => [
        'odm' => [
            'connection' => [
                'commerce' => [
                    'dbname' => $mongoZoopDatabase,
                    'connectionString' => $mongoConnectionString,
                ],
            ],
            'configuration' => [
                'commerce' => [
                    'metadata_cache' => 'doctrine.cache.array',
                    'default_db' => $mongoZoopDatabase,
                ]
            ],
        ],
    ],
    'zoop' => [
        'aws' => [
            'key' => 'AKIAJE2QFIBMYF5V5MUQ',
            'secret' => '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',
            's3' => [
                'buckets' => [
                    'test' => 'zoop-web-assets-test',
                ],
                'endpoint' => [
                    'test' => 'https://zoop-web-assets-test.s3.amazonaws.com',
                ],
            ],
        ],
        'db' => [
            'host' => 'localhost',
            'database' => $mysqlZoopDatabase,
            'username' => 'zoop',
            'password' => 'yourtown1',
            'port' => 3306,
        ],
        'cache' => [
            'handler' => 'mongodb',
            'mongodb' => [
                'connectionString' => $mongoConnectionString,
                'options' => [
                    'database' => $mongoZoopDatabase,
                    'collection' => 'Cache',
                ]
            ],
        ],
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
                    'secondary_receivers' => []
                ]
            ]
        ],
        'sendgrid' => [
            'username' => '',
            'password' => ''
        ],
        'session' => [
            'ttl' => (60 * 60 * 3), //3 hours
            'handler' => 'mongodb',
            'mongodb' => [
                'connectionString' => $mongoConnectionString,
                'options' => [
                    'database' => $mongoZoopDatabase,
                    'collection' => 'Session',
                    'saveOptions' => [
                        'w' => 1
                    ]
                ]
            ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            'zoop.commerce.store.active' => 'Zoop\Payment\Test\ActiveStoreFactory'
        ],
    ],
];
