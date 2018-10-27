<?php
namespace CmsApi\V1\Rest\Posts;

use CmsApi\Service\PostService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostsResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostsResource(
            $container->get(PostService::class)
        );
    }
}
