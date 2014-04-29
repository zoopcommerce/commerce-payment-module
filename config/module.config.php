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
            'Zoop\Payment\Gateway\Service\AbstractGatewayFactory' //zoop.payment.gateway.{gateway_name}
        ]
    ],
];
