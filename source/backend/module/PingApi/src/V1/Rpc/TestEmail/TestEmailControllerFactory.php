<?php

namespace PingApi\V1\Rpc\TestEmail;

use Application\Service\AppMail;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TestEmailControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TestEmailController(
            $container->get(AppMail::class)
        );
    }
}
