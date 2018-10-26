<?php

namespace CmsApi\Service;

use Application\Service\Utility;
use CmsApi\Entity\Slider;
use CmsApi\Message\SliderMessage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class SliderService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Slider
     */
    private $slider;

    /**
     * @var array
     */
    private $uploadDir;

    public function __construct(
        EntityManager $entityManager,
        array $uploadDir
    ) {
        $this->entityManager = $entityManager;
        $this->uploadDir = $uploadDir;
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Slider::class);
    }

    /**
     * @param int $id
     *
     * @return SliderService
     * @internal param bool $exception
     *
     */
    public function getById(int $id): SliderService
    {
        /** @var Slider $slider */
        $slider = $this->getRepository()->find($id);

        if (empty($slider)) {
            throw new \RuntimeException(SliderMessage::ERR_MSG_NOT_FOUND, SliderMessage::ERR_CODE_NOT_FOUND);
        }

        $this->slider = $slider;
        return $this;
    }

    /**
     * @return Slider[]
     */
    public function fetchAll(): array
    {
        $sliders = $this->getRepository()->findAll();
        return $sliders;
    }

    /**
     * @return Slider
     */
    public function fetch(): Slider
    {
        return $this->slider;
    }

    /**
     * @param string $text
     * @param bool   $enable
     * @param string $image
     *
     * @return Slider
     */
    public function create(
        string $text,
        bool $enable,
        string $image
    ): Slider {
        $this->moveImage($image);
        $slider = new Slider([
            'text' => $text,
            'isEnable' => $enable,
            'image' => $image,
        ]);
        $this->entityManager->persist($slider);
        $this->entityManager->flush();

        return $slider;
    }

    /**
     * @return Slider
     * @internal param int $id
     *
     */
    public function delete(): Slider
    {
        $slider = $this->slider;
        $this->removeImage($slider->getImage());

        $this->entityManager->remove($slider);
        $this->entityManager->flush();

        return $slider;
    }

    /**
     * Delete a list of ids and return number of successfully deleted records
     *
     * @param int[] $ids
     *
     * @return int
     */
    public function deleteSliders(array $ids): int
    {
        Utility::isArrayOfIds($ids);

        $qb = $this->entityManager->createQueryBuilder();

        $images = $qb->select('u.image')
            ->from(Slider::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        foreach ($images as $image) {
            $this->removeImage($image['image']);
        }

        /** @var int $result */
        $result = $qb->delete(Slider::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        return $result;
    }

    /**
     * @param array $info
     *
     * @return Slider
     */
    public function edit(array $info): Slider
    {
        $slider = $this->slider;

        if (!empty($info['image'])) {
            $this->moveImage($info['image']);
            $slider->setImage($info['image']);
        }

        $slider->setText($info['text']);
        $slider->setIsEnable($info['enable']);
        $slider->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($slider);
        $this->entityManager->flush();

        return $slider;
    }

    /**
     * @param string $image
     *
     * @return bool
     */
    private function removeImage(string $image): bool
    {
        $file = $this->uploadDir['slider'].'/'.$image;
        if (file_exists($file)) {
            return unlink($file);
        }

        return false;
    }

    /**
     * @param string $filename
     *
     * @return bool
     */
    private function moveImage(string $filename): bool
    {
        if ($this->slider) {
            $this->removeImage($this->slider->getImage());
        }

        $temp = $this->uploadDir['tmp'].'/'.$filename;
        if (file_exists($temp)) {
            return rename($temp, $this->uploadDir['slider'].'/'.$filename);
        }

        return false;
    }
}
