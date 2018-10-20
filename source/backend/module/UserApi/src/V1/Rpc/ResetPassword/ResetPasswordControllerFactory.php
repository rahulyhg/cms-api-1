<?php
namespace UserApi\V1\Rpc\ResetPassword;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ResetPasswordControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ResetPasswordController(
            $container->get(UserService::class)
        );
    }
}
