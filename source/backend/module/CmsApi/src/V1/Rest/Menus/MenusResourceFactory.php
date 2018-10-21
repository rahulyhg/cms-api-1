<?php
namespace CmsApi\V1\Rest\Menus;

use Interop\Container\ContainerInterface;
use CmsApi\Service\MenuService;
use Zend\ServiceManager\Factory\FactoryInterface;

class MenusResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenusResource(
            $container->get(MenuService::class)
        );
    }
}
