<?php

namespace UserApi\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use DoctrineModule\Validator\ObjectExists;
use UserApi\Entity\User;
use UserApi\Type\UserStatus;
use Zend\Crypt\Password\Bcrypt;
use Zend\Validator\ValidatorChain;

class UserService implements UserServiceInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EmailService
     */
    private $email;

    public function __construct(
        EntityManager $entityManager,
        EmailService $email
    ) {
        $this->entityManager = $entityManager;
        $this->email = $email;
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
            'fields' => $field,
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
     *
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
        if (!$this->getById($id)) {
            return null;
        }

        /** @var User $user */
        $user = $this->getRepository()->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function getByEmail(string $email): ?User
    {
        /** @var User $user */
        $user = $this->getRepository()->findOneBy([
            'email' => $email,
        ]);

        return $user;
    }

    /**
     * @param int $status
     *
     * @return User[]
     */
    public function getByStatus(int $status): array
    {
        /** @var User[] $users */
        $users = $this->getRepository()->findBy([
            'status' => $status,
        ]);

        return $users;
    }

    /**
     * @return string
     */
    private function generateToken(): string
    {
        $token = openssl_random_pseudo_bytes(16);
        return bin2hex($token);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private function encryptPassword(string $password): string
    {
        $bcrypt = new Bcrypt(['cost' => 14]);
        return $bcrypt->create($password);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function addUserByAdmin(string $email, string $password): User
    {
        return $this->create($email, $password, UserStatus::STATUS_ENABLE);
    }

    /**
     * @param string $email
     * @param string $password
     * @param int    $status
     *
     * @return User
     */
    private function create(string $email, string $password, int $status): User
    {
        $user = $this->getByEmail($email);

        if (!empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_ALREADY_EXIST, User::ERR_CODE_ALREADY_EXIST);
        }

        $user = new User([
            'email' => $email,
            'password' => $this->encryptPassword($password),
            'status' => $status,
        ]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int[] $ids
     *
     * @return User[]
     */
    public function deleteUsers(array $ids): array
    {
        $this->isArrayOfNumber($ids);

        $users = [];
        foreach ($ids as $id) {
            if ($user = $this->delete($id)) {
                $users[] = $user;
            };
        }

        return $users;
    }

    /**
     * @param int $id
     * @param int $status
     *
     * @return User
     */
    public function changeStatus(int $id, int $status): User
    {
        $user = $this->getById($id);

        if (!$user) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        if (!in_array($status, UserStatus::toArray())) {
            throw new \RuntimeException(User::ERR_MSG_WRONG_STATUS, User::ERR_CODE_WRONG_STATUS);
        }
        var_dump($user->getId());

        $user->setStatus($status);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int[] $ids
     * @param int   $status
     *
     * @return User[]
     */
    public function changeStatusUsers(array $ids, int $status): array
    {
        $this->isArrayOfNumber($ids);

        $users = [];
        foreach ($ids as $id) {
            if ($user = $this->changeStatus($id, $status)) {
                $users[] = $user;
            };
        }

        return $users;
    }

    /**
     * @param int[] $items
     */
    private function isArrayOfNumber(array $items)
    {
        if ($items !== array_filter($items, 'is_numeric')) {
            throw new \RuntimeException(User::ERR_MSG_INVALID_ID_TYPE, User::ERR_CODE_INVALID_ID_TYPE);
        }
    }

    /**
     * @param string $email
     */
    public function sendResetPassword(string $email)
    {
        $user = $this->getByEmail($email);

        if (empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        $user->setResetToken($this->generateToken());
        $user->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->email->sendResetPasswordToken($user);
    }

    public function resetPassword()
    {

    }

    /**
     * @param string $email
     */
    public function sendConfirmEmail(string $email)
    {
        $user = $this->getByEmail($email);

        if (empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        $user->setEmailConfirmToken($this->generateToken());
        $user->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->email->sendConfirmEmailToken($user);
    }

    public function confirmEmail()
    {
        // getUserByConfirmEmailToken();
        // update user confirm email token
        // update user isConfirmedEmail
    }

    public function getByResetToken()
    {

    }

    public function login()
    {

    }

    public function edit()
    {

    }

    public function register(string $email, string $password): User
    {
        return $this->create($email, $password, UserStatus::STATUS_DISABLE);
    }
}
