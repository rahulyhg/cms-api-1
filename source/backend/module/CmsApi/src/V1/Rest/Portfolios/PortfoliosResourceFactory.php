<?php

namespace CmsApi\V1\Rest\Portfolios;

use CmsApi\Service\PortfolioService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PortfoliosResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PortfoliosResource(
            $container->get(PortfolioService::class)
        );
    }
}
