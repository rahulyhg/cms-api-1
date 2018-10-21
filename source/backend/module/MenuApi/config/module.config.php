<?php
return [
    'service_manager' => [
        'factories' => [
            \MenuApi\V1\Rest\Menus\MenusResource::class => \MenuApi\V1\Rest\Menus\MenusResourceFactory::class,
            \MenuApi\Service\MenuService::class => \MenuApi\Service\Factory\MenuServiceFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            'MenuApi_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => __DIR__ . '/../src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'MenuApi\\Entity' => 'MenuApi_driver',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'menu-api.rest.menus' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/menus[/:menu_id]',
                    'defaults' => [
                        'controller' => 'MenuApi\\V1\\Rest\\Menus\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'menu-api.rest.menus',
        ],
    ],
    'zf-rest' => [
        'MenuApi\\V1\\Rest\\Menus\\Controller' => [
            'listener' => \MenuApi\V1\Rest\Menus\MenusResource::class,
            'route_name' => 'menu-api.rest.menus',
            'route_identifier_name' => 'menus_id',
            'collection_name' => 'menus',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \MenuApi\Entity\Menu::class,
            'collection_class' => \MenuApi\V1\Rest\Menus\MenusCollection::class,
            'service_name' => 'menus',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'MenuApi\\V1\\Rest\\Menus\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'MenuApi\\V1\\Rest\\Menus\\Controller' => [
                0 => 'application/vnd.menu-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'MenuApi\\V1\\Rest\\Menus\\Controller' => [
                0 => 'application/vnd.menu-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \MenuApi\V1\Rest\Menus\MenusEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'menu-api.rest.menus',
                'route_identifier_name' => 'menus_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
            \MenuApi\V1\Rest\Menus\MenusCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'menu-api.rest.menus',
                'route_identifier_name' => 'menus_id',
                'is_collection' => true,
            ],
            \MenuApi\Entity\Menu::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'menu-api.rest.menus',
                'route_identifier_name' => 'menus_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
        ],
    ],
];
