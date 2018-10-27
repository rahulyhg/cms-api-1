<?php

namespace CmsApi\Service;

use Application\Service\Utility;
use CmsApi\Entity\Post;
use CmsApi\Message\PostMessage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PostService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Post
     */
    private $post;

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
        return $this->entityManager->getRepository(Post::class);
    }

    /**
     * @param int $id
     *
     * @return PostService
     * @internal param bool $exception
     *
     */
    public function getById(int $id): PostService
    {
        /** @var Post $post */
        $post = $this->getRepository()->find($id);

        if (empty($post)) {
            throw new \RuntimeException(PostMessage::ERR_MSG_NOT_FOUND, PostMessage::ERR_CODE_NOT_FOUND);
        }

        $this->post = $post;
        return $this;
    }

    /**
     * @return Post[]
     */
    public function fetchAll(): array
    {
        $posts = $this->getRepository()->findAll();
        return $posts;
    }

    /**
     * @return Post
     */
    public function fetch(): Post
    {
        return $this->post;
    }

    /**
     * @param string $title
     * @param string $text
     * @param bool   $published
     * @param string $image
     *
     * @return Post
     */
    public function create(
        string $title,
        string $text,
        bool $published,
        string $image
    ): Post {
        $this->moveImage($image);
        $post = new Post([
            'title' => $title,
            'text' => $text,
            'isPublished' => $published,
            'image' => $image,
        ]);
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }

    /**
     * @return Post
     * @internal param int $id
     *
     */
    public function delete(): Post
    {
        $post = $this->post;
        $this->removeImage($post->getImage());

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return $post;
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
            ->from(Post::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        foreach ($images as $image) {
            $this->removeImage($image['image']);
        }

        /** @var int $result */
        $result = $qb->delete(Post::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        return $result;
    }

    /**
     * @param array $info
     *
     * @return Post
     */
    public function edit(array $info): Post
    {
        $post = $this->post;

        if (!empty($info['image'])) {
            $this->moveImage($info['image']);
            $post->setImage($info['image']);
        }

        $post->setText($info['text']);
        $post->setIsEnable($info['enable']);
        $post->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }

    /**
     * @param string $image
     *
     * @return bool
     */
    private function removeImage(string $image): bool
    {
        $file = $this->uploadDir['post'].'/'.$image;
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
        if ($this->post) {
            $this->removeImage($this->post->getImage());
        }

        $temp = $this->uploadDir['tmp'].'/'.$filename;
        if (file_exists($temp)) {
            return rename($temp, $this->uploadDir['post'].'/'.$filename);
        }

        return false;
    }
}
