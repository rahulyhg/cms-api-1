<?php
/*
namespace {$module}\Controller\Factory;

use Interop\Container\ContainerInterface;
use {$module}\Controller\{$module}Controller;
use Zend\ServiceManager\Factory\FactoryInterface;

class {$module}ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new {$module}Controller();
    }
}
