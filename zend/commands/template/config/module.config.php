<?php
/* REMOVE
namespace {$module};

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use {$module}\Controller\{$module}Controller;
use {$module}\Factory\{$module}ControllerFactory;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            '{$lowerModule}' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/{$lowerModule}',
                    'defaults' => [
                        'controller' => {$module}Controller::class,
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            {$module}Controller::class => {$module}ControllerFactory::class,
//            IndexController::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
//            IndexController::class => function (\Zend\ServiceManager\ServiceManager $container) {
//                return new SomeModelAsService();
//            },
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__.'_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__.'/../src/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__.'\Entity' => __NAMESPACE__.'_driver',
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__.'/../view'
        ],
    ],
//    'view_helpers' => [
//        'invokables' => [
//            'nariFormElement' => FormElement::class
//        ]
//    ]
];
