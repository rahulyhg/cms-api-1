<?php

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;

return [
    'zf-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'dummy' => [],
        ],
    ],
    'session_config' => [
        'cookie_lifetime' => 60 * 60 * 1,               // Session cookie will expire in 1 hour.
        'gc_maxlifetime' => 60 * 60 * 24 * 30,          // Session data will be stored on server maximum for 30 days.
    ],
    'session_manager' => [
        'validators' => [                               // Session validators (used for security).
            RemoteAddr::class,
            HttpUserAgent::class,
        ],
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class,
    ],
];
