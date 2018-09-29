<?php

namespace UserApi\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use DoctrineModule\Validator\ObjectExists;
use UserApi\Entity\User;
use Zend\Validator\ValidatorChain;

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

    /**
     * @param int $id
     * @return null|User
     */
    public function getById(int $id): ?User
    {
        $validator = new ValidatorChain();
        $validator->attach(new ObjectExists([
            'object_repository' => $this->getRepository(),
            'fields' => 'id'
        ]));

        if (!$validator->isValid($id)) {
            return null;
        }

        return $this->getRepository()->find($id);
    }
}
