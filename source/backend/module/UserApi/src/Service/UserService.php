<?php

namespace UserApi\Service;

use Application\Service\AppMail;
use Application\Service\Utility;
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
    private $user;

    /** @var User[] */
    private $users;

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

        $this->user = $user;
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

        $this->user = $user;
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

        $this->user = $user;
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

        $this->users = $users;
        return $this;
    }

    /******************************************************
     ******************** Repository **********************
     ******************************************************/
    /**
     * @return array
     */
    public function fetchAll(): array
    {
        $users = $this->getRepository()->findAll();
        return $users;
    }

    /**
     * @return User
     */
    public function fetch(): User
    {
        return $this->user;
    }

    /**
     * @return User
     * @internal param int $id
     *
     */
    public function delete(): User
    {
        $user = $this->user;

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * Delete a list of ids and return number of successfully deleted records
     *
     * @param int[] $ids
     *
     * @return int
     */
    public function deleteUsers(array $ids): int
    {
        Utility::isArrayOfIds($ids);

        $qb = $this->entityManager->createQueryBuilder();

        /** @var int $result */
        $result = $qb->delete(User::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        return $result;
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
            'emailConfirmToken' => Utility::generateToken(),
        ]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param array $info
     *
     * @return User
     */
    public function edit(array $info): User
    {
        $user = $this->user;

        if ($info['email'] !== $user->getEmail()) {
            if ($this->getRepository()->count(['email' => $info['email']])) {
                throw new \RuntimeException(User::ERR_MSG_ALREADY_EXIST, User::ERR_CODE_ALREADY_EXIST);
            }
            $user->setEmail($info['email']);
            $user->setIsEmailConfirmed(false);
        }

        $user->setFullname($info['fullname']);
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /******************************************************
     ******************** UserService *********************
     ******************************************************/
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
        $user = $this->create($email, $fullname, $password, UserStatus::STATUS_ENABLE);
        $this->email->send(
            'user-api/mail/new-account.phtml',
            'New Account',
            $user->getEmail(), [
                'email' => $user->getEmail(),
                'emailConfirmToken' => $user->getEmailConfirmToken(),
                'fullname' => $user->getFullname(),
                'plainPassword' => $password,
            ]);
        return $user;
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
        $user = $this->user;

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

    /**
     * @internal param string $email
     */
    public function sendConfirmEmail(): void
    {
        $user = $this->user;

        $user->setEmailConfirmToken(Utility::generateToken());
        $user->setIsEmailConfirmed(false);
        $user->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->email->send(
            'user-api/mail/confirm-email.phtml',
            'Confirm Your Email',
            $user->getEmail(),
            $user
        );
    }

    /**
     * @return UserService
     * @internal param string $email
     * @internal param string $token
     *
     */
    public function confirmEmail(): UserService
    {
        $user = $this->user;

        $user->setUpdatedAt(new \DateTime());
        $user->setIsEmailConfirmed(true);
        $user->setEmailConfirmToken(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * @param int $status
     *
     * @return UserService
     * @internal param int $id
     */
    public function changeStatus(int $status): UserService
    {
        if (empty($this->user)) {
            $this->userNotFoundException(true);
        }
        $user = $this->user;

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
        Utility::isArrayOfIds($ids);

        $users = [];
        foreach ($ids as $id) {
            if ($user = $this->changeStatus($id, $status)) {
                $users[] = $user;
            };
        }

        return $users;
    }

    /**
     * @param string $email
     */
    public function sendResetPassword(string $email)
    {
        $user = $this->getByEmail($email);

        $user->setResetToken(Utility::generateToken());
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
}
