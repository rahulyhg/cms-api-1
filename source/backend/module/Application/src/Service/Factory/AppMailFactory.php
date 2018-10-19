<?php

namespace Application\Service\Factory;

use Application\Service\AppMail;
use Application\Service\MailComposer;
use Interop\Container\ContainerInterface;
use MtMail\Service\Mail;
use MtMail\Service\Sender;
use MtMail\Service\TemplateManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class AppMailFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $email = new Mail(
            $container->get(MailComposer::class),
            $container->get(Sender::class),
            $container->get(TemplateManager::class)
        );
        return new AppMail($email);
    }
}
