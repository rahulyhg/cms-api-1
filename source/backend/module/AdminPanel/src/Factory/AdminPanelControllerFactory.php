<?php

namespace AdminPanel\Factory;

use Interop\Container\ContainerInterface;
use AdminPanel\Controller\AdminPanelController;
use Zend\ServiceManager\Factory\FactoryInterface;

class AdminPanelControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminPanelController();
    }
}
