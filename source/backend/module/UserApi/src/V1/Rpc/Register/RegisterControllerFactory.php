<?php
namespace UserApi\V1\Rpc\Register;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class RegisterControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        return new RegisterController(
            $userService
        );
    }
}
