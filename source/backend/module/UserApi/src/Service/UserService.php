<?php

namespace UserApi\Service;

use Application\Service\AppMail;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use UserApi\Entity\User;
use UserApi\Type\UserStatus;
use Zend\Crypt\Password\Bcrypt;

class UserService implements UserServiceInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /** @var User */
    private $_user;

    /** @var User[] */
    private $_users;

    /**
     * @var AppMail
     */
    private $email;

    public function __construct(
        EntityManager $entityManager,
        AppMail $email
    ) {
        $this->entityManager = $entityManager;
        $this->email = $email;
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @param int  $id
     * @param bool $exception
     *
     * @return UserService
     */
    public function getById(int $id, bool $exception = false): UserService
    {
        /** @var User $user */
        $user = $this->getRepository()->find($id);

        if (empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        $this->_user = $user;
        return $this;
    }

    /**
     * @param string $email
     *
     * @return UserService
     * @internal param bool $exception
     *
     */
    public function getByEmail(string $email): UserService
    {
        /** @var User $user */
        $user = $this->getRepository()->findOneBy([
            'email' => $email,
        ]);

        if (empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        $this->_user = $user;
        return $this;
    }

    /**
     * @param string $email
     * @param string $token
     * @param string $type
     *
     * @return UserService
     */
    public function getByToken(string $email, string $token, string $type): UserService
    {
        $field = [
            'emailConfirm' => 'emailConfirmToken',
            'resetPassword' => 'resetToken',
        ];

        if (empty($field[$type])) {
            throw new \RuntimeException(User::ERR_MSG_INVALID_PARAMETER, User::ERR_CODE_INVALID_PARAMETER);
        }

        /** @var User $user */
        $user = $this->getRepository()->findOneBy([
            'email' => $email,
            $field[$type] => $token,
        ]);


        if (empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        $this->_user = $user;
        return $this;
    }

    /**
     * @param int $status
     *
     * @return UserService
     */
    public function getByStatus(int $status): UserService
    {
        /** @var User[] $users */
        $users = $this->getRepository()->findBy([
            'status' => $status,
        ]);

        if (empty($users)) {
            throw new \RuntimeException(User::ERR_MSG_NOT_FOUND, User::ERR_CODE_NOT_FOUND);
        }

        $this->_users = $users;
        return $this;
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
     * @param string $fullname
     * @param string $password
     *
     * @return User
     */
    public function addUserByAdmin(string $email, string $fullname, string $password): User
    {
        return $this->create($email, $fullname, $password, UserStatus::STATUS_ENABLE);
    }

    /**
     * @param string $email
     * @param string $fullname
     * @param string $password
     *
     * @return User
     */
    public function register(string $email, string $fullname, string $password): User
    {
        $user = $this->create($email, $fullname, $password, UserStatus::STATUS_DISABLE);
        $this->email->send(
            'user-api/mail/registration.phtml',
            'Registration',
            $user->getEmail(),
            $user);
        return $user;
    }

    /**
     * @param string $email
     * @param string $fullname
     * @param string $password
     * @param int    $status
     *
     * @return User
     * @internal param null|string $emailConfirmToken
     *
     */
    private function create(
        string $email,
        string $fullname,
        string $password,
        int $status
    ): User {
        /** @var User $user */
        $user = $this->getRepository()->findOneBy([
            'email' => $email,
        ]);

        if (!empty($user)) {
            throw new \RuntimeException(User::ERR_MSG_ALREADY_EXIST, User::ERR_CODE_ALREADY_EXIST);
        }

        $user = new User([
            'email' => $email,
            'password' => $this->encryptPassword($password),
            'fullname' => $fullname,
            'status' => $status,
            'emailConfirmToken' => UserStatus::STATUS_DISABLE === $status ? $this->generateToken() : null,
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
     * @param int $status
     *
     * @return UserService
     * @internal param int $id
     */
    public function changeStatus(int $status): UserService
    {
        if (empty($this->_user)) {
            $this->userNotFoundException(true);
        }
        $user = $this->_user;

        if (!in_array($status, UserStatus::toArray())) {
            throw new \RuntimeException(User::ERR_MSG_WRONG_STATUS, User::ERR_CODE_WRONG_STATUS);
        }

        $user->setStatus($status);
        $this->entityManager->flush();

        return $this;
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
            throw new \RuntimeException(User::ERR_MSG_INVALID_PARAMETER, User::ERR_CODE_INVALID_PARAMETER);
        }
    }

    /**
     * @param string $email
     */
    public function sendResetPassword(string $email)
    {
        $user = $this->getByEmail($email);

        $user->setResetToken($this->generateToken());
        $user->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->email->send('user-api/mail/reset-password.phtml', []);
    }

    /**
     * @param string $email
     * @param string $token
     * @param string $password
     */
    public function resetPassword(string $email, string $token, string $password)
    {
        $user = $this->getByToken($email, $token, 'resetPassword');
        $user->setUpdatedAt(new \DateTime());
        $user->setPassword($this->encryptPassword($password));
        $user->setResetToken(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param string $email
     */
    public function sendConfirmEmail(string $email)
    {
        $user = $this->getByEmail($email);

        $user->setEmailConfirmToken($this->generateToken());
        $user->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->email->send('user-api/mail/confirm-email.phtml', []);
    }

    /**
     * @return UserService
     * @internal param string $email
     * @internal param string $token
     *
     */
    public function confirmEmail(): UserService
    {
        if (empty($this->_user)) {
            $this->userNotFoundException(true);
        }
        $user = $this->_user;

        $user->setUpdatedAt(new \DateTime());
        $user->setIsEmailConfirmed(true);
        $user->setEmailConfirmToken(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * @param string $password
     * @param string $hashedPassword
     *
     * @return bool
     */
    public function isPasswordCorrect(string $password, string $hashedPassword): bool
    {
        $bcrypt = new Bcrypt(['cost' => 14]);
        return $bcrypt->verify($password, $hashedPassword);
    }

    /**
     * @param string $password
     *
     * @return User
     * @internal param string $email
     */
    public function login(string $password): User
    {
        $user = $this->_user;

        if ($user->getStatus() !== UserStatus::STATUS_ENABLE) {
            throw new \RuntimeException(User::ERR_MSG_IS_NO_ACTIVE, User::ERR_CODE_IS_NO_ACTIVE);
        }

        if (!$user->isEmailConfirmed()) {
            throw new \RuntimeException(User::ERR_MSG_EMAIL_IS_NOT_CONFIRMED, User::ERR_CODE_EMAIL_IS_NOT_CONFIRMED);
        }

        if (!$this->isPasswordCorrect($password, $user->getPassword())) {
            throw new \RuntimeException(User::ERR_MSG_PASSWORD_IS_NOT_CORRECT, User::ERR_CODE_PASSWORD_IS_NOT_CORRECT);
        }

        return $user;
    }

    public function edit(int $id, array $info): User
    {
        $user = $this->getById($id);

        if (!empty($info['email'])) {
            $user->setEmail($info['email']);
        }

        if (!empty($info['password'])) {
            $user->setPassword($this->encryptPassword($info['password']));
        }
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
