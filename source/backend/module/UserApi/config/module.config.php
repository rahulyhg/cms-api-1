<?php
return [
    'service_manager' => [
        'factories' => [
            \UserApi\V1\Rest\Users\UsersResource::class => \UserApi\V1\Rest\Users\UsersResourceFactory::class,
            \UserApi\Service\UserService::class => \UserApi\Factory\UserServiceFactory::class,
            \UserApi\Service\EmailService::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'user-api.rest.users' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/users[/:users_id]',
                    'constraints' => [
                        'users_id' => '[1-9]+[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rest\\Users\\Controller',
                    ],
                ],
            ],
            'user-api.rpc.user-login' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/login',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\UserLogin\\Controller',
                        'action' => 'userLogin',
                    ],
                ],
            ],
            'user-api.rpc.check-user' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/is-loggedin',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\CheckUser\\Controller',
                        'action' => 'checkUser',
                    ],
                ],
            ],
            'user-api.rpc.user-logout' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/logout',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\UserLogout\\Controller',
                        'action' => 'userLogout',
                    ],
                ],
            ],
        ],
    ],
    'session_containers' => [
        0 => 'ApplicationSessionContainer',
    ],
    'input_filter_specs' => [
        'UserApi\\V1\\Rpc\\UserExist\\Validator' => [],
        'UserApi\\V1\\Rpc\\UserLogin\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
                'field_type' => 'string',
                'continue_if_empty' => false,
                'error_message' => 'Please enter a valid email address.',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '16',
                            'min' => '6',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'password',
                'field_type' => 'string',
                'error_message' => 'Password is required and it should be a text between 6 and 16 characters.',
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            'UserApi_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => __DIR__ . '/../src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'UserApi\\Entity' => 'UserApi_driver',
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'UserApi\\V1\\Rpc\\UserLogin\\Controller' => \UserApi\V1\Rpc\UserLogin\UserLoginControllerFactory::class,
            'UserApi\\V1\\Rpc\\CheckUser\\Controller' => \UserApi\V1\Rpc\CheckUser\CheckUserControllerFactory::class,
            'UserApi\\V1\\Rpc\\UserLogout\\Controller' => \UserApi\V1\Rpc\UserLogout\UserLogoutControllerFactory::class,
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'user-api.rest.users',
            2 => 'user-api.rpc.user-login',
            3 => 'user-api.rpc.check-user',
            4 => 'user-api.rpc.user-logout',
        ],
    ],
    'zf-rest' => [
        'UserApi\\V1\\Rest\\Users\\Controller' => [
            'listener' => \UserApi\V1\Rest\Users\UsersResource::class,
            'route_name' => 'user-api.rest.users',
            'route_identifier_name' => 'users_id',
            'collection_name' => 'users',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
                3 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \UserApi\Entity\User::class,
            'collection_class' => \UserApi\V1\Rest\Users\UsersCollection::class,
            'service_name' => 'users',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'UserApi\\V1\\Rest\\Users\\Controller' => 'HalJson',
            'UserApi\\V1\\Rpc\\UserLogin\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\CheckUser\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\UserLogout\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'UserApi\\V1\\Rest\\Users\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\UserLogin\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\CheckUser\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\UserLogout\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'UserApi\\V1\\Rest\\Users\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\UserLogin\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\CheckUser\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\UserLogout\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            'UserApi\\V1\\Rest\\Users\\User' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-api.rest.users',
                'route_identifier_name' => 'users_id',
                'hydrator' => \Zend\Hydrator\Reflection::class,
            ],
            \UserApi\V1\Rest\Users\UsersCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-api.rest.users',
                'route_identifier_name' => 'users_id',
                'is_collection' => true,
            ],
            \UserApi\Entity\User::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-api.rest.users',
                'route_identifier_name' => 'users_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
        ],
    ],
    'zf-rpc' => [
        'UserApi\\V1\\Rpc\\UserLogin\\Controller' => [
            'service_name' => 'userLogin',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user-api.rpc.user-login',
        ],
        'UserApi\\V1\\Rpc\\CheckUser\\Controller' => [
            'service_name' => 'checkUser',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user-api.rpc.check-user',
        ],
        'UserApi\\V1\\Rpc\\UserLogout\\Controller' => [
            'service_name' => 'userLogout',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user-api.rpc.user-logout',
        ],
    ],
    'zf-content-validation' => [
        'UserApi\\V1\\Rpc\\UserLogin\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\UserLogin\\Validator',
        ],
    ],
];
