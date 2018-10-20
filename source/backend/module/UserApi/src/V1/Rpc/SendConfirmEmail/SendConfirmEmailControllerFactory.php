<?php
namespace UserApi\V1\Rpc\SendConfirmEmail;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class SendConfirmEmailControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SendConfirmEmailController(
            $container->get(UserService::class)
        );
    }
}
