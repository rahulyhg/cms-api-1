<?php

namespace Application\Service;

class ImageManager
{
    /**
     * @var array
     */
    private $uploadDir;

    public function __construct(
        array $uploadDir
    ) {
        $this->uploadDir = $uploadDir;
    }

    // Returns the image file content. On error, returns boolean false.
    public function getImageFileContent($filePath)
    {
        return file_get_contents($filePath);
    }

    // Retrieves the file information (size, MIME type) by image path.
    public function getImageFileInfo($filePath)
    {
        if (!is_readable($filePath)) {
            return false;
        }

        // Get MIME type of the file.
        $finfo = finfo_open(FILEINFO_MIME);
        $mimeType = finfo_file($finfo, $filePath);
        if($mimeType===false)
            $mimeType = 'application/octet-stream';

        return [
            'size' => filesize($filePath),
            'type' => $mimeType
        ];
    }

    // Resizes the image, keeping its aspect ratio.
    public  function resizeImage($filePath, $desiredWidth = 240)
    {
        list($originalWidth, $originalHeight) = getimagesize($filePath);

        $aspectRatio = $originalWidth/$originalHeight;
        $desiredHeight = $desiredWidth/$aspectRatio;

        $fileInfo = $this->getImageFileInfo($filePath);

        $resultingImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
        if (substr($fileInfo['type'], 0, 9) =='image/png')
            $originalImage = imagecreatefrompng($filePath);
        else
            $originalImage = imagecreatefromjpeg($filePath);
        imagecopyresampled($resultingImage, $originalImage, 0, 0, 0, 0,
            $desiredWidth, $desiredHeight, $originalWidth, $originalHeight);

        $tmpFileName = tempnam($this->uploadDir['tmp'], "FOO");
        imagejpeg($resultingImage, $tmpFileName, 80);

        return $tmpFileName;
    }
}
