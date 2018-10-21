<?php
namespace UserApi\V1\Rpc\ResetPasswordLink;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ResetPasswordLinkControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ResetPasswordLinkController(
            $container->get(UserService::class)
        );
    }
}
