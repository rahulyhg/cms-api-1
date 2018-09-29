<?php

namespace UserApi\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use UserApi\Entity\User;

class UserService implements UserServiceInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $users = $this->getRepository()->findAll();
        return $users;
    }
}
