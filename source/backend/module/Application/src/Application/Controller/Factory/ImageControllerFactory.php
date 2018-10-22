<?php

namespace Application\Controller\Factory;

use Application\Controller\ImageController;
use Application\Service\ImageManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ImageControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ImageController(
            $container->get(ImageManager::class)
        );
    }
}
