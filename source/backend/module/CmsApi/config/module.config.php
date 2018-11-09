<?php
return [
    'service_manager' => [
        'factories' => [
            \CmsApi\V1\Rest\Menus\MenusResource::class => \CmsApi\V1\Rest\Menus\MenusResourceFactory::class,
            \CmsApi\Service\MenuService::class => \CmsApi\Service\Factory\MenuServiceFactory::class,
            \CmsApi\V1\Rest\Sliders\SlidersResource::class => \CmsApi\V1\Rest\Sliders\SlidersResourceFactory::class,
            \CmsApi\Service\SliderService::class => \CmsApi\Service\Factory\SliderServiceFactory::class,
            \CmsApi\Service\PostService::class => \CmsApi\Service\Factory\PostServiceFactory::class,
            \CmsApi\V1\Rest\Posts\PostsResource::class => \CmsApi\V1\Rest\Posts\PostsResourceFactory::class,
            \CmsApi\Service\PortfolioService::class => \CmsApi\Service\Factory\PortfolioServiceFactory::class,
            \CmsApi\V1\Rest\Portfolios\PortfoliosResource::class => \CmsApi\V1\Rest\Portfolios\PortfoliosResourceFactory::class,
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
            'cms-api.rpc.images' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/images/:type/:filename',
                    'defaults' => [
                        'controller' => 'CmsApi\\V1\\Rpc\\Images\\Controller',
                        'action' => 'images',
                    ],
                ],
            ],
            'cms-api.rest.posts' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/posts[/:post_id]',
                    'defaults' => [
                        'controller' => 'CmsApi\\V1\\Rest\\Posts\\Controller',
                    ],
                ],
            ],
            'cms-api.rest.portfolios' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/portfolios[/:portfolios_id]',
                    'defaults' => [
                        'controller' => 'CmsApi\\V1\\Rest\\Portfolios\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'menu-api.rest.menus',
            1 => 'cms-api.rest.sliders',
            2 => 'cms-api.rpc.images',
            3 => 'cms-api.rest.posts',
            4 => 'cms-api.rest.portfolios',
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
        'CmsApi\\V1\\Rest\\Posts\\Controller' => [
            'listener' => \CmsApi\V1\Rest\Posts\PostsResource::class,
            'route_name' => 'cms-api.rest.posts',
            'route_identifier_name' => 'post_id',
            'collection_name' => 'posts',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \CmsApi\Entity\Post::class,
            'collection_class' => \CmsApi\V1\Rest\Posts\PostsCollection::class,
            'service_name' => 'posts',
        ],
        'CmsApi\\V1\\Rest\\Portfolios\\Controller' => [
            'listener' => \CmsApi\V1\Rest\Portfolios\PortfoliosResource::class,
            'route_name' => 'cms-api.rest.portfolios',
            'route_identifier_name' => 'portfolios_id',
            'collection_name' => 'portfolios',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \CmsApi\Entity\Portfolio::class,
            'collection_class' => \CmsApi\V1\Rest\Portfolios\PortfoliosCollection::class,
            'service_name' => 'portfolios',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'CmsApi\\V1\\Rest\\Menus\\Controller' => 'HalJson',
            'CmsApi\\V1\\Rest\\Sliders\\Controller' => 'HalJson',
            'CmsApi\\V1\\Rpc\\Images\\Controller' => 'Json',
            'CmsApi\\V1\\Rest\\Posts\\Controller' => 'HalJson',
            'CmsApi\\V1\\Rest\\Portfolios\\Controller' => 'HalJson',
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
            'CmsApi\\V1\\Rpc\\Images\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'CmsApi\\V1\\Rest\\Posts\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'CmsApi\\V1\\Rest\\Portfolios\\Controller' => [
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
            'CmsApi\\V1\\Rpc\\Images\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/json',
            ],
            'CmsApi\\V1\\Rest\\Posts\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/json',
            ],
            'CmsApi\\V1\\Rest\\Portfolios\\Controller' => [
                0 => 'application/vnd.cms-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
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
            \CmsApi\V1\Rest\Posts\PostsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.posts',
                'route_identifier_name' => 'post_id',
                'is_collection' => true,
            ],
            \CmsApi\Entity\Post::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.posts',
                'route_identifier_name' => 'post_id',
                'hydrator' => \DoctrineModule\Stdlib\Hydrator\DoctrineObject::class,
            ],
            \CmsApi\V1\Rest\Portfolios\PortfoliosCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.portfolios',
                'route_identifier_name' => 'portfolios_id',
                'is_collection' => true,
            ],
            \CmsApi\Entity\Portfolio::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'cms-api.rest.portfolios',
                'route_identifier_name' => 'portfolios_id',
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
            'PUT' => 'CmsApi\\V1\\Rest\\Sliders\\Validator\\PUT',
        ],
        'CmsApi\\V1\\Rest\\Posts\\Controller' => [
            'input_filter' => 'CmsApi\\V1\\Rest\\Posts\\Validator',
        ],
        'CmsApi\\V1\\Rest\\Portfolios\\Controller' => [
            'input_filter' => 'CmsApi\\V1\\Rest\\Portfolios\\Validator',
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
        'CmsApi\\V1\\Rest\\Sliders\\Validator\\PUT' => [
            0 => [
                'required' => false,
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
                            'target' => 'data/tmp/slider',
                            'useUploadExtension' => true,
                        ],
                    ],
                ],
                'name' => 'file',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [
                            'allowTags' => [
                                0 => 'a',
                                1 => 'img',
                                2 => 'div',
                                3 => 'span',
                                4 => 'b',
                                5 => 'u',
                                6 => 'i',
                                7 => 'strong',
                                8 => 'p',
                            ],
                            'allowAttribs' => [
                                0 => 'class',
                                1 => 'id',
                                2 => 'src',
                                3 => 'href',
                            ],
                        ],
                    ],
                ],
                'name' => 'text',
                'allow_empty' => false,
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Boolean::class,
                        'options' => [],
                    ],
                ],
                'name' => 'enable',
                'field_type' => 'bool',
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
                            'target' => 'data/tmp/slider',
                            'useUploadExtension' => true,
                        ],
                    ],
                ],
                'name' => 'file',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [
                            'allowTags' => [
                                0 => 'a',
                                1 => 'img',
                                2 => 'div',
                                3 => 'span',
                                4 => 'b',
                                5 => 'u',
                                6 => 'i',
                                7 => 'strong',
                                8 => 'p',
                            ],
                            'allowAttribs' => [
                                0 => 'class',
                                1 => 'id',
                                2 => 'src',
                                3 => 'href',
                            ],
                        ],
                    ],
                ],
                'name' => 'text',
                'allow_empty' => false,
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Boolean::class,
                        'options' => [],
                    ],
                ],
                'name' => 'enable',
                'field_type' => 'bool',
                'allow_empty' => true,
            ],
        ],
        'CmsApi\\V1\\Rest\\Posts\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^[a-zA-Z]+[a-zA-Z0-9-_ )(?!,#$]*$/',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'title',
                'field_type' => 'string',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [
                            'allowTags' => [
                                0 => 'a',
                                1 => 'img',
                                2 => 'div',
                                3 => 'span',
                                4 => 'b',
                                5 => 'u',
                                6 => 'i',
                                7 => 'strong',
                                8 => 'p',
                            ],
                            'allowAttribs' => [
                                0 => 'class',
                                1 => 'id',
                                2 => 'src',
                                3 => 'href',
                            ],
                        ],
                    ],
                ],
                'name' => 'text',
                'allow_empty' => true,
            ],
            2 => [
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
                'name' => 'published',
                'field_type' => 'bool',
                'allow_empty' => true,
            ],
            3 => [
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
                            'target' => 'data/tmp/post',
                            'useUploadExtension' => true,
                        ],
                    ],
                ],
                'type' => \Zend\InputFilter\FileInput::class,
                'name' => 'file',
            ],
        ],
        'CmsApi\\V1\\Rest\\Portfolios\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^[a-zA-Z]+[a-zA-Z0-9-_ )(?!,#$]*$/',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'title',
                'field_type' => 'string',
                'allow_empty' => false,
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uri::class,
                        'options' => [
                            'allowAbsolute' => true,
                            'allowRelative' => false,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\UriNormalize::class,
                        'options' => [],
                    ],
                ],
                'name' => 'link',
                'field_type' => 'string',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                        'options' => [
                            'allowTags' => [
                                0 => 'a',
                                1 => 'img',
                                2 => 'div',
                                3 => 'span',
                                4 => 'b',
                                5 => 'u',
                                6 => 'i',
                                7 => 'strong',
                                8 => 'p',
                            ],
                            'allowAttribs' => [
                                0 => 'class',
                                1 => 'id',
                                2 => 'src',
                                3 => 'href',
                            ],
                        ],
                    ],
                ],
                'name' => 'text',
                'allow_empty' => true,
                'field_type' => 'string',
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
                'name' => 'published',
                'field_type' => 'bool',
                'allow_empty' => true,
            ],
            4 => [
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
                            'use_upload_extension' => true,
                            'target' => 'data/tmp/portfolio',
                        ],
                    ],
                ],
                'name' => 'file',
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'CmsApi\\V1\\Rpc\\Images\\Controller' => \CmsApi\V1\Rpc\Images\ImagesControllerFactory::class,
        ],
    ],
    'zf-rpc' => [
        'CmsApi\\V1\\Rpc\\Images\\Controller' => [
            'service_name' => 'images',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'cms-api.rpc.images',
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'CmsApi\\V1\\Rest\\Sliders\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
            'CmsApi\\V1\\Rest\\Menus\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
            'CmsApi\\V1\\Rest\\Posts\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
            'CmsApi\\V1\\Rest\\Portfolios\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
