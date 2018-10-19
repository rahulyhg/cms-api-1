<?php
namespace UserApi\V1\Rpc\ConfirmEmail;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfirmEmailControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ConfirmEmailController(
            $container->get(UserService::class)
        );
    }
}
