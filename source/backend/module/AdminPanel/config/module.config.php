<?php

namespace AdminPanel;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use AdminPanel\Controller\AdminPanelController;
use AdminPanel\Factory\AdminPanelControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'adminpanel' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin[/:pages]',
                    'constraints' => [
                        'pages' => '[a-zA-Z0-9-/]*'
                    ],
                    'defaults' => [
                        'controller' => AdminPanelController::class,
                        'action' => 'index'
                    ],
                    'may_terminate' => false,
                ]
            ],
        ]
    ],
    'controllers' => [
        'factories' => [
            AdminPanelController::class => AdminPanelControllerFactory::class,
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
