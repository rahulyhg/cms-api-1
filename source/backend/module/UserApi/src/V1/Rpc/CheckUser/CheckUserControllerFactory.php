<?php
namespace UserApi\V1\Rpc\CheckUser;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class CheckUserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CheckUserController(
            $container->get(UserService::class)
        );
    }
}
