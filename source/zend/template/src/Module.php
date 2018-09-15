<?php
/*
namespace {$module};

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    public function getConfig(): array
    {
        return include __DIR__.'/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
        return [];
    }
}
