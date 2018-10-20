<?php
namespace UserApi\V1\Rpc\SendResetPassword;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class SendResetPasswordControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SendResetPasswordController(
            $container->get(UserService::class)
        );
    }
}
