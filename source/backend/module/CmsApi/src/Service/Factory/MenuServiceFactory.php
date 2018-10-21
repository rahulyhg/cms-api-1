<?php

namespace CmsApi\Service\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use CmsApi\Service\MenuService;
use Zend\ServiceManager\Factory\FactoryInterface;

class MenuServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenuService(
            $container->get(EntityManager::class)
        );
    }
}
