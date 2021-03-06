<?php

namespace Application;

use Application\Service\AppMail;
use Application\Service\Factory\AppMailFactory;
use Application\Service\Factory\ImageManagerFactory;
use Application\Service\Factory\MailComposerFactory;
use Application\Service\MailComposer;
use Application\Service\Utility;
use UserApi\Initializer\iAuthAwareInitializer;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__.'/../view/layout/layout.phtml',
            'application/index/index' => __DIR__.'/../view/application/index/index.phtml',
            'error/404' => __DIR__.'/../view/error/404.phtml',
            'error/index' => __DIR__.'/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            MailComposer::class => MailComposerFactory::class,
            AppMail::class => AppMailFactory::class,
            Utility::class => InvokableFactory::class,
            Service\ImageManager::class => ImageManagerFactory::class,
        ],
        'initializers' => array(
            'iAuthAwareInterface' => iAuthAwareInitializer::class,
        )
    ],
];
