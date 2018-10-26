<?php
namespace CmsApi\V1\Rest\Sliders;

use CmsApi\Service\SliderService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SlidersResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SlidersResource(
            $container->get(SliderService::class)
        );
    }
}
