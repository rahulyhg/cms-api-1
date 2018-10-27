<?php

namespace CmsApi\Service\Factory;

use CmsApi\Service\PostService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new PostService(
            $container->get(EntityManager::class),
            $config['upload_dir']
        );
    }
}
