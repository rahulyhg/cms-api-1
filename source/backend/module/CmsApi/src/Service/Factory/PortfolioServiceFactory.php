<?php

namespace CmsApi\Service\Factory;

use CmsApi\Service\PortfolioService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PortfolioServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new PortfolioService(
            $container->get(EntityManager::class),
            $config['upload_dir']
        );
    }
}
