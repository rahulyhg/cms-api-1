<?php
return [
    'service_manager' => [
        'factories' => [
            \UserApi\V1\Rest\Users\UsersResource::class => \UserApi\V1\Rest\Users\UsersResourceFactory::class,
            \UserApi\Service\UserService::class => \UserApi\Service\Factory\UserServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            0 => __DIR__ . '/../view',
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
                    'route' => '/api/user-guard',
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
            'user-api.rpc.register' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/register',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\Register\\Controller',
                        'action' => 'register',
                    ],
                ],
            ],
            'user-api.rpc.confirm-email' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/confirm/:email/:token',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\ConfirmEmail\\Controller',
                        'action' => 'confirmEmail',
                    ],
                ],
            ],
            'user-api.rpc.send-confirm-email' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/send-confirm-email',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller',
                        'action' => 'sendConfirmEmail',
                    ],
                ],
            ],
            'user-api.rpc.activate-account' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/activate/:email/:token',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\ActivateAccount\\Controller',
                        'action' => 'activateAccount',
                    ],
                ],
            ],
            'user-api.rpc.reset-password' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/reset-password',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\ResetPassword\\Controller',
                        'action' => 'resetPassword',
                    ],
                ],
            ],
            'user-api.rpc.send-reset-password' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/send-reset-password',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\SendResetPassword\\Controller',
                        'action' => 'sendResetPassword',
                    ],
                ],
            ],
            'user-api.rpc.reset-paswword-link' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/reset/:email/:token',
                    'defaults' => [
                        'controller' => 'UserApi\\V1\\Rpc\\ResetPaswwordLink\\Controller',
                        'action' => 'resetPaswwordLink',
                    ],
                ],
            ],
        ],
    ],
    'session_containers' => [
        0 => 'ApplicationSessionContainer',
    ],
    'input_filter_specs' => [
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
        'UserApi\\V1\\Rpc\\Register\\Validator' => [
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
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '5',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'fullname',
                'field_type' => 'string',
                'error_message' => 'Each user account should have a name, Please enter a name.',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Identical::class,
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'confirmPassword',
                'field_type' => 'string',
                'error_message' => 'Confirm Password should be same as password.',
            ],
        ],
        'UserApi\\V1\\Rest\\Users\\Validator' => [
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
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => '5',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'fullname',
                'field_type' => 'string',
            ],
        ],
        'UserApi\\V1\\Rpc\\SendConfirmEmail\\Validator' => [
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
            ],
        ],
        'UserApi\\V1\\Rpc\\ResetPassword\\Validator' => [
            0 => [
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
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Identical::class,
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'confirmPassword',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Digits::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'id',
                'field_type' => 'int',
            ],
        ],
        'UserApi\\V1\\Rpc\\SendResetPassword\\Validator' => [
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
            'UserApi\\V1\\Rpc\\Register\\Controller' => \UserApi\V1\Rpc\Register\RegisterControllerFactory::class,
            'UserApi\\V1\\Rpc\\ConfirmEmail\\Controller' => \UserApi\V1\Rpc\ConfirmEmail\ConfirmEmailControllerFactory::class,
            'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller' => \UserApi\V1\Rpc\SendConfirmEmail\SendConfirmEmailControllerFactory::class,
            'UserApi\\V1\\Rpc\\ActivateAccount\\Controller' => \UserApi\V1\Rpc\ActivateAccount\ActivateAccountControllerFactory::class,
            'UserApi\\V1\\Rpc\\ResetPassword\\Controller' => \UserApi\V1\Rpc\ResetPassword\ResetPasswordControllerFactory::class,
            'UserApi\\V1\\Rpc\\SendResetPassword\\Controller' => \UserApi\V1\Rpc\SendResetPassword\SendResetPasswordControllerFactory::class,
            'UserApi\\V1\\Rpc\\ResetPaswwordLink\\Controller' => \UserApi\V1\Rpc\ResetPaswwordLink\ResetPaswwordLinkControllerFactory::class,
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'user-api.rest.users',
            2 => 'user-api.rpc.user-login',
            3 => 'user-api.rpc.check-user',
            4 => 'user-api.rpc.user-logout',
            5 => 'user-api.rpc.register',
            6 => 'user-api.rpc.confirm-email',
            7 => 'user-api.rpc.send-confirm-email',
            8 => 'user-api.rpc.activate-account',
            9 => 'user-api.rpc.reset-password',
            10 => 'user-api.rpc.send-reset-password',
            11 => 'user-api.rpc.reset-paswword-link',
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
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'POST',
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
            'UserApi\\V1\\Rpc\\Register\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\ConfirmEmail\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\ActivateAccount\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\ResetPassword\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\SendResetPassword\\Controller' => 'Json',
            'UserApi\\V1\\Rpc\\ResetPaswwordLink\\Controller' => 'Json',
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
            'UserApi\\V1\\Rpc\\Register\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\ConfirmEmail\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\ActivateAccount\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\ResetPassword\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\SendResetPassword\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'UserApi\\V1\\Rpc\\ResetPaswwordLink\\Controller' => [
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
            'UserApi\\V1\\Rpc\\Register\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\ConfirmEmail\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\ActivateAccount\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\ResetPassword\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\SendResetPassword\\Controller' => [
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ],
            'UserApi\\V1\\Rpc\\ResetPaswwordLink\\Controller' => [
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
        'UserApi\\V1\\Rpc\\Register\\Controller' => [
            'service_name' => 'register',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user-api.rpc.register',
        ],
        'UserApi\\V1\\Rpc\\ConfirmEmail\\Controller' => [
            'service_name' => 'confirmEmail',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user-api.rpc.confirm-email',
        ],
        'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller' => [
            'service_name' => 'sendConfirmEmail',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user-api.rpc.send-confirm-email',
        ],
        'UserApi\\V1\\Rpc\\ActivateAccount\\Controller' => [
            'service_name' => 'activateAccount',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user-api.rpc.activate-account',
        ],
        'UserApi\\V1\\Rpc\\ResetPassword\\Controller' => [
            'service_name' => 'resetPassword',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user-api.rpc.reset-password',
        ],
        'UserApi\\V1\\Rpc\\SendResetPassword\\Controller' => [
            'service_name' => 'sendResetPassword',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'user-api.rpc.send-reset-password',
        ],
        'UserApi\\V1\\Rpc\\ResetPaswwordLink\\Controller' => [
            'service_name' => 'resetPaswwordLink',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user-api.rpc.reset-paswword-link',
        ],
    ],
    'zf-content-validation' => [
        'UserApi\\V1\\Rpc\\UserLogin\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\UserLogin\\Validator',
        ],
        'UserApi\\V1\\Rpc\\Register\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\Register\\Validator',
        ],
        'UserApi\\V1\\Rest\\Users\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rest\\Users\\Validator',
        ],
        'UserApi\\V1\\Rpc\\SendConfirmEmail\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\SendConfirmEmail\\Validator',
        ],
        'UserApi\\V1\\Rpc\\ResetPassword\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\ResetPassword\\Validator',
        ],
        'UserApi\\V1\\Rpc\\SendResetPassword\\Controller' => [
            'input_filter' => 'UserApi\\V1\\Rpc\\SendResetPassword\\Validator',
        ],
    ],
];
