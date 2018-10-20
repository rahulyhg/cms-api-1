<?php
namespace UserApi\V1\Rpc\ActivateAccount;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ActivateAccountControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ActivateAccountController(
            $container->get(UserService::class)
        );
    }
}
