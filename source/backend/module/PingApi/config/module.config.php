<?php
return [
    'service_manager' => [
        'factories' => [
            'UserApi\\Service\\EmailService' => 'UserApi\\Factory\\EmailServiceFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            0 => __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'factories' => [
            'PingApi\\V1\\Rpc\\TestEmail\\Controller' => \PingApi\V1\Rpc\TestEmail\TestEmailControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'ping-api.rpc.test-email' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/ping/email',
                    'defaults' => [
                        'controller' => 'PingApi\\V1\\Rpc\\TestEmail\\Controller',
                        'action' => 'testEmail',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'ping-api.rpc.test-email',
        ],
    ],
    'zf-rpc' => [
        'PingApi\\V1\\Rpc\\TestEmail\\Controller' => [
            'service_name' => 'testEmail',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'ping-api.rpc.test-email',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'PingApi\\V1\\Rpc\\TestEmail\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'PingApi\\V1\\Rpc\\TestEmail\\Controller' => [
                0 => 'application/vnd.ping-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'PingApi\\V1\\Rpc\\TestEmail\\Controller' => [
                0 => 'application/vnd.ping-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-content-validation' => [
        'PingApi\\V1\\Rpc\\TestEmail\\Controller' => [
            'input_filter' => 'PingApi\\V1\\Rpc\\TestEmail\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'PingApi\\V1\\Rpc\\TestEmail\\Validator' => [],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'PingApi\\V1\\Rpc\\TestEmail\\Controller' => [
                'actions' => [
                    'testEmail' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
        ],
    ],
];
