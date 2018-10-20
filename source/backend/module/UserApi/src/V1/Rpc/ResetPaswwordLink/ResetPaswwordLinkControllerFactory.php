<?php
namespace UserApi\V1\Rpc\ResetPaswwordLink;

use Interop\Container\ContainerInterface;
use UserApi\Service\UserService;
use Zend\ServiceManager\Factory\FactoryInterface;

class ResetPaswwordLinkControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ResetPaswwordLinkController(
            $container->get(UserService::class)
        );
    }
}
