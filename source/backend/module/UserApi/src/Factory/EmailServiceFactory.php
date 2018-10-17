<?php

namespace UserApi\Factory;

use Interop\Container\ContainerInterface;
use MtMail\Service\Mail;
use UserApi\Service\EmailService;
use Zend\ServiceManager\Factory\FactoryInterface;

class EmailServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (defined('TEST_ENV')) {
            $email = null;
        } else {
            $email = $container->get(Mail::class);
        }

        return new EmailService($email);
    }
}
