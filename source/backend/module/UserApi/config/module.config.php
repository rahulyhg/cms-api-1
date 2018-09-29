<?php

use UserApi\Factory\UserServiceFactory;
use UserApi\Service\UserService;

return [
    'service_manager' => [
        'factories' => [
            \UserApi\V1\Rest\Users\UsersResource::class => \UserApi\V1\Rest\Users\UsersResourceFactory::class,
            UserService::class => UserServiceFactory::class
        ],
    ],
    'router' => [
        'routes' => [
            'user-api.rest.users' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/users[/:users_id]',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rest\\Users\\Controller',
                    ],
                ],
            ],
            'user-api.rpc.user-exist' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user-exist[/:id]',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\UserExist\\Controller',
                        'action' => 'userExist',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'user-api.rest.users',
            1 => 'user-api.rpc.user-exist',
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
                3 => 'PATCH',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
                3 => 'PUT',
                4 => 'PATCH',
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
            'UserApi\\V1\\Rpc\\UserExist\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'UserApi\\V1\\Rest\\Users\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\UserExist\\Controller' => [
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
            'UserApi\\V1\\Rpc\\UserExist\\Controller' => [
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
    'controllers' => [
        'factories' => [
            'UserApi\\V1\\Rpc\\UserExist\\Controller' => \UserApi\V1\Rpc\UserExist\UserExistControllerFactory::class,
        ],
    ],
    'zf-rpc' => [
        'UserApi\\V1\\Rpc\\UserExist\\Controller' => [
            'service_name' => 'userExist',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user-api.rpc.user-exist',
        ],
    ],
    'zf-content-validation' => [
        'UserApi\\V1\\Rpc\\UserExist\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\UserExist\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'UserApi\\V1\\Rpc\\UserExist\\Validator' => [],
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
];
