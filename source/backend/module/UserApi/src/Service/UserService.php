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
     * @param string $field
     * @param int    $id
     *
     * @return bool
     */
    private function isExist(string $field, int $id): bool
    {
        $validator = new ValidatorChain();
        $validator->attach(new ObjectExists([
            'object_repository' => $this->getRepository(),
            'fields' => $field
        ]));

        return $validator->isValid($id);
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
        if (!$this->isExist('id', $id)) {
            return null;
        }

        /** @var User $user */
        $user = $this->getRepository()->find($id);
        return $user;
    }

    /**
     * @param int $id
     *
     * @return null|User
     */
    public function delete(int $id): ?User
    {
        if (!$this->isExist('id', $id)) {
            return null;
        }

        /** @var User $user */
        $user = $this->getRepository()->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $user;
    }
}
