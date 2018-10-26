<?php

namespace CmsApi\Service\Factory;

use CmsApi\Service\SliderService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SliderServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new SliderService(
            $container->get(EntityManager::class),
            $config['upload_dir']
        );
    }
}
