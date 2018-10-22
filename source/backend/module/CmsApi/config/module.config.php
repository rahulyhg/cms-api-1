<?php
return [
    'service_manager' => [
        'factories' => [
            \CmsApi\V1\Rest\Menus\MenusResource::class => \CmsApi\V1\Rest\Menus\MenusResourceFactory::class,
            \CmsApi\Service\MenuService::class => \CmsApi\Service\Factory\MenuServiceFactory::class,
            \CmsApi\V1\Rest\Sliders\SlidersResource::class => \CmsApi\V1\Rest\Sliders\SlidersResourceFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            'CmsApi_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => __DIR__ . '/../src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'CmsApi\\Entity' => 'CmsApi_driver',
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
                        'controller' => 'CmsApi\\V1\\Rest\\Menus\\Controller',
                    ],
                ],
            ],
            'cms-api.rest.sliders' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/sliders[/:sliders_id]',
                    'defaults' => [
                        'controller' => 'CmsApi\\V1\\Rest\\Sliders\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'menu-api.rest.menus',
            1 => 'cms-api.rest.sliders',
        ],
    ],
    'zf-rest' => [
        'CmsApi\\V1\\Rest\\Menus\\Controller' => [
            'listener' => \CmsApi\V1\Rest\Menus\MenusResource::class,
            'route_name' => 'menu-api.rest.menus',
            'route_identifier_name' => 'menu_id',
            'collection_name' => 'menus',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \CmsApi\Entity\Menu::class,
            'collection_class' => \CmsApi\V1\Rest\Menus\MenusCollection::class,
            'service_name' => 'menus',
        ],
        'CmsApi\\V1\\Rest\\Sliders\\Controller' => [
            'listener' => \CmsApi\V1\Rest\Sliders\SlidersResource::class,
            'route_name' => 'cms-api.rest.sliders',
            'route_identifier_name' => 'sliders_id',
            'collection_name' => 'sliders',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
                3 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \CmsApi\Entity\Slider::class,
            'collection_class' => \CmsApi\V1\Rest\Sliders\SlidersCollection::class,
            'service_name' => 'sliders',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'CmsApi\\V1\\Rest\\Menus\\Controller' => 'HalJson',
            'CmsApi\\V1\\Rest\\Sliders\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'CmsApi\\V1\\Rest\\Menus\\Controller' => [
                0 => 'application/vnd.menu-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'CmsApi\\V1\\Rest\\Sliders\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'CmsApi\\V1\\Rest\\Menus\\Controller' => [
                0 => 'application/vnd.menu-api.v1+json',
                1 => 'application/json',
            ],
            'CmsApi\\V1\\Rest\\Sliders\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            'CmsApi\\V1\\Rest\\Menus\\MenusEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'menu-api.rest.menus',
                'route_identifier_name' => 'menus_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
            \CmsApi\V1\Rest\Menus\MenusCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'menu-api.rest.menus',
                'route_identifier_name' => 'menu_id',
                'is_collection' => true,
            ],
            \CmsApi\Entity\Menu::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'menu-api.rest.menus',
                'route_identifier_name' => 'menu_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
            'CmsApi\\V1\\Rest\\Sliders\\SlidersEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.sliders',
                'route_identifier_name' => 'sliders_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \CmsApi\V1\Rest\Sliders\SlidersCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.sliders',
                'route_identifier_name' => 'sliders_id',
                'is_collection' => true,
            ],
            \CmsApi\Entity\Slider::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.sliders',
                'route_identifier_name' => 'sliders_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
        ],
    ],
    'zf-content-validation' => [
        'CmsApi\\V1\\Rest\\Menus\\Controller' => [
            'input_filter' => 'CmsApi\\V1\\Rest\\Menus\\Validator',
        ],
        'CmsApi\\V1\\Rest\\Sliders\\Controller' => [
            'input_filter' => 'CmsApi\\V1\\Rest\\Sliders\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'CmsApi\\V1\\Rest\\Menus\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alpha::class,
                        'options' => [
                            'allowwhitespace' => true,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^[a-zA-Z]+[a-zA-Z0-9_-]*$/',
                            'message' => 'The slug is not valid format',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'slug',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uri::class,
                        'options' => [
                            'allowRelative' => true,
                            'allowAbsolute' => true,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'link',
                'allow_empty' => true,
            ],
            3 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Boolean::class,
                        'options' => [
                            'casting' => true,
                        ],
                    ],
                ],
                'name' => 'enable',
                'allow_empty' => true,
            ],
            4 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Boolean::class,
                        'options' => [
                            'casting' => true,
                        ],
                    ],
                ],
                'name' => 'newWindow',
                'allow_empty' => true,
            ],
        ],
        'CmsApi\\V1\\Rest\\Sliders\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\IsImage::class,
                        'options' => [
                            'mimeType' => 'image/jpeg,image/png',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'target' => 'data/tmp/',
                        ],
                    ],
                ],
                'name' => 'file',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
        ],
    ],
];
