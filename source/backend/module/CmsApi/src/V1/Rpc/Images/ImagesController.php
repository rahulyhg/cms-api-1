<?php

namespace CmsApi\V1\Rpc\Images;

use Application\Service\ImageManager;
use Zend\Mvc\Controller\AbstractActionController;

class ImagesController extends AbstractActionController
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var array
     */
    private $uploadDir;

    public function __construct(
        array $uploadDir,
        ImageManager $imageManager
    ) {
        $this->imageManager = $imageManager;
        $this->uploadDir = $uploadDir;
    }

    public function imagesAction()
    {
        $response = $this->getResponse();

        $type = $this->params()->fromRoute('type');
        $dir = $this->uploadDir[$type];

        if (empty($dir)) {
            $response->setStatusCode(404);
            return;
        }

        $fileName = $dir.'/'.$this->params()->fromRoute('filename');

        $thumbnailSize = (int)$this->params()->fromQuery('thumbnail', 0);
        if ($thumbnailSize) {
            $fileName = $this->imageManager->resizeImage($fileName, $thumbnailSize);
        }
        // Get image file info (size and MIME type).
        $fileInfo = $this->imageManager->getImageFileInfo($fileName);
        if ($fileInfo === false) {
            $response->setStatusCode(404);
            return;
        }

        // Write HTTP headers.
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: ".$fileInfo['type']);
        $headers->addHeaderLine("Content-length: ".$fileInfo['size']);

        // Write file content.
        $fileContent = $this->imageManager->getImageFileContent($fileName);
        if ($fileContent !== false) {
            $response->setContent($fileContent);
        } else {
            $response->setStatusCode(500);
            return;
        }

        if ($thumbnailSize) {
            unlink($fileName);
        }

        return $this->getResponse();
    }
}
