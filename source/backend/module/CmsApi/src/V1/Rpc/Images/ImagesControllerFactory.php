<?php
namespace CmsApi\V1\Rpc\Images;

use Application\Service\ImageManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ImagesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new ImagesController(
            $config['upload_dir'],
            $container->get(ImageManager::class)
        );
    }
}
