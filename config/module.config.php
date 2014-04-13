<?php

return [
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
            'zoop.payment.gateway.paypal.chainedpayment'
        ]
    ],
];
