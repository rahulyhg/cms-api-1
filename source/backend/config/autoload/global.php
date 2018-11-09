<?php
return [
    'zf-content-negotiation' => [
        'selectors' => [],
    ],
    'session_config' => [
        'cookie_lifetime' => 3600,
        'gc_maxlifetime' => 2592000,
    ],
    'session_manager' => [
        'validators' => [
            0 => \Zend\Session\Validator\RemoteAddr::class,
            1 => \Zend\Session\Validator\HttpUserAgent::class,
        ],
    ],
    'session_storage' => [
        'type' => \Zend\Session\Storage\SessionArrayStorage::class,
    ],
    'upload_dir' => [
        'tmp' => '/var/www/html/config/autoload/../../data/tmp',
        'slider' => '/var/www/html/config/autoload/../../data/upload/slider',
        'post' => '/var/www/html/config/autoload/../../data/upload/post',
        'portfolio' => '/var/www/html/config/autoload/../../data/upload/portfolio',
    ],
    'zf-mvc-auth' => [
        'authentication' => [
            'map' => [
                'PingApi\\V1' => 'oauth2_doctrine',
                'CmsApi\\V1' => 'oauth2_doctrine',
                'UserApi\\V1' => 'oauth2_doctrine',
            ],
        ],
    ],
];
