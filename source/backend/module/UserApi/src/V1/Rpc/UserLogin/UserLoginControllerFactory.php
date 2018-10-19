<?php
namespace UserApi\V1\Rpc\UserLogin;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserLoginControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserLoginController(
            $container->get(UserService::class)
        );
    }
}
