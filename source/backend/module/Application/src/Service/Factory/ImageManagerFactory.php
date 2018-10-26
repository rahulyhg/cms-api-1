<?php

namespace Application\Service\Factory;

use Application\Service\ImageManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ImageManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new ImageManager(
            $config['upload_dir']
        );
    }
}
