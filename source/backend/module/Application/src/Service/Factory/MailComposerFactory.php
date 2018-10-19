<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use MtMail\Renderer\RendererInterface;
use MtMail\Service\ComposerPluginManager;
use Application\Service\MailComposer;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailComposerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('Configuration');
        /** @var RendererInterface $renderer */
        $renderer = $container->get($configuration['mt_mail']['renderer']);
        $service = new MailComposer($renderer);

        $pluginManager = $container->get(ComposerPluginManager::class);

        if (isset($configuration['mt_mail']['composer_plugins'])
            && is_array($configuration['mt_mail']['composer_plugins'])
        ) {
            foreach (array_unique($configuration['mt_mail']['composer_plugins']) as $plugin) {
                $pluginManager->get($plugin)->attach($service->getEventManager());
            }
        }

        return $service;
    }
}
