<?php

namespace UserApi\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use UserApi\Service\EmailService;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);
        $email = $container->get(EmailService::class);

        return new UserService($em, $email);
    }
}
