<?php

namespace CmsApi\Service;

use Application\Service\Utility;
use CmsApi\Entity\Portfolio;
use CmsApi\Message\PostMessage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PortfolioService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Portfolio
     */
    private $portfolio;

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
        return $this->entityManager->getRepository(Portfolio::class);
    }

    /**
     * @param int $id
     *
     * @return PortfolioService
     * @internal param bool $exception
     *
     */
    public function getById(int $id): PortfolioService
    {
        /** @var Portfolio $portfolio */
        $portfolio = $this->getRepository()->find($id);

        if (empty($portfolio)) {
            throw new \RuntimeException(PostMessage::ERR_MSG_NOT_FOUND, PostMessage::ERR_CODE_NOT_FOUND);
        }

        $this->portfolio = $portfolio;
        return $this;
    }

    /**
     * @return Portfolio[]
     */
    public function fetchAll(): array
    {
        $portfolios = $this->getRepository()->findAll();
        return $portfolios;
    }

    /**
     * @return Portfolio[]
     */
    public function fetchAllPublished(): array
    {
        $portfolio = $this->getRepository()->findBy(['isPublished' => true]);
        return $portfolio;
    }

    /**
     * @return Portfolio
     */
    public function fetch(): Portfolio
    {
        return $this->portfolio;
    }

    /**
     * @param string $title
     * @param string $link
     * @param string $text
     * @param bool   $published
     * @param string $image
     *
     * @return Portfolio
     */
    public function create(
        string $title,
        string $link,
        string $text,
        bool $published,
        string $image
    ): Portfolio {
        $this->moveImage($image);
        $portfolio = new Portfolio([
            'title' => $title,
            'link' => $link,
            'text' => $text,
            'isPublished' => $published,
            'image' => $image,
        ]);
        $this->entityManager->persist($portfolio);
        $this->entityManager->flush();

        return $portfolio;
    }

    /**
     * @return Portfolio
     * @internal param int $id
     *
     */
    public function delete(): Portfolio
    {
        $portfolio = $this->portfolio;
        $this->removeImage($portfolio->getImage());

        $this->entityManager->remove($portfolio);
        $this->entityManager->flush();

        return $portfolio;
    }

    /**
     * Delete a list of ids and return number of successfully deleted records
     *
     * @param int[] $ids
     *
     * @return int
     */
    public function deletePosts(array $ids): int
    {
        Utility::isArrayOfIds($ids);

        $qb = $this->entityManager->createQueryBuilder();

        $images = $qb->select('u.image')
            ->from(Portfolio::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        foreach ($images as $image) {
            $this->removeImage($image['image']);
        }

        /** @var int $result */
        $result = $qb->delete(Portfolio::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        return $result;
    }

    /**
     * @param array $info
     *
     * @return Portfolio
     */
    public function edit(array $info): Portfolio
    {
        $portfolio = $this->portfolio;

        if (!empty($info['image'])) {
            $this->moveImage($info['image']);
            $portfolio->setImage($info['image']);
        }

        $portfolio->setText($info['text']);
        $portfolio->setIsEnable($info['enable']);
        $portfolio->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($portfolio);
        $this->entityManager->flush();

        return $portfolio;
    }

    /**
     * @param string $image
     *
     * @return bool
     */
    private function removeImage(string $image): bool
    {
        $file = $this->uploadDir['portfolio'].'/'.$image;
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
        if ($this->portfolio) {
            $this->removeImage($this->portfolio->getImage());
        }

        $temp = $this->uploadDir['tmp'].'/'.$filename;
        if (file_exists($temp)) {
            return rename($temp, $this->uploadDir['portfolio'].'/'.$filename);
        }

        return false;
    }
}
