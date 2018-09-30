<?php

namespace ModuleTests;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

error_reporting(E_ALL | E_STRICT);

if (!defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', 'test');
}

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__.'/../'));
}

/**
 * Class Bootstrap
 */
class Bootstrap
{
    /**
     * @var ServiceManager
     */
    protected static $serviceManager;

    public static function init(): void
    {
        if (!class_exists(AutoloaderFactory::class)) {
            throw new \RuntimeException('Unable to load ZF2. Run `php composer.phar install`');
        }

        AutoloaderFactory::factory([
            StandardAutoloader::class => [
                'autoregister_zf' => true,
                'namespaces' => [
                    __NAMESPACE__ => __DIR__.'/'.__NAMESPACE__,
                ],
            ],
        ]);

        $app_config = require __DIR__ . '/../config/application.config.php';

        if (file_exists(APPLICATION_PATH . '/config/development.config.php')) {
            $app_config = ArrayUtils::merge(
                $app_config,
                include APPLICATION_PATH . '/config/development.config.php'
            );
        }

        // use ModuleManager to load this module and it's dependencies
        $config = [
            'module_listener_options' => [
                'config_glob_paths' => [
                    sprintf(__DIR__ . '/../config/autoload/{,*.}{global,%s,local}.php', APPLICATION_ENV)
                ],
                'module_paths' => [
                    __DIR__.'/../vendor',
                    __DIR__.'/../module',
                ]
            ],
            'modules' => $app_config['modules']
        ];

        $serviceManager = new ServiceManager((new ServiceManagerConfig())->toArray());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    /**
     * @return ServiceManager
     */
    public static function getServiceManager(): ServiceManager
    {
        return static::$serviceManager;
    }
}

Bootstrap::init();