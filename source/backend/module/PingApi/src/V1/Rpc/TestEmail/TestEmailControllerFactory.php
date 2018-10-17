<?php
namespace PingApi\V1\Rpc\TestEmail;

use Interop\Container\ContainerInterface;
use UserApi\Service\EmailService;
use Zend\ServiceManager\Factory\FactoryInterface;

class TestEmailControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $email =$container->get(EmailService::class);
        return new TestEmailController($email);
    }
}
