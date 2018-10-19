<?php

namespace UserApi\Service\Factory;

use Application\Service\AppMail;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserService(
            $container->get(EntityManager::class),
            $container->get(AppMail::class)
        );
    }
}
