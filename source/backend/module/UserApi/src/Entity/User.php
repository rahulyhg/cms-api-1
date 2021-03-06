<?php

namespace UserApi\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserApi\Type\UserStatus;
use ZF\OAuth2\Doctrine\Entity\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 * References for Doctrine ORM Entity:
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/annotations-reference.html#index
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.4/reference/basic-mapping.html#doctrine-mapping-types
 */
class User implements UserInterface
{
    const ERR_CODE_ALREADY_EXIST = 1;
    const ERR_MSG_ALREADY_EXIST = 'The email address has been taken.';
    const ERR_CODE_NOT_FOUND = 2;
    const ERR_MSG_NOT_FOUND = 'User does not exist.';
    const ERR_CODE_INVALID_PARAMETER = 3;
    const ERR_MSG_INVALID_PARAMETER = 'Invalid parameter.';
    const ERR_CODE_WRONG_STATUS = 4;
    const ERR_MSG_WRONG_STATUS = 'Invalid user status.';
    const ERR_CODE_IS_NO_ACTIVE = 5;
    const ERR_MSG_IS_NO_ACTIVE = 'User account is not active.';
    const ERR_CODE_EMAIL_IS_NOT_CONFIRMED = 6;
    const ERR_MSG_EMAIL_IS_NOT_CONFIRMED = 'User email is not confirmed.';
    const ERR_CODE_PASSWORD_IS_NOT_CORRECT = 7;
    const ERR_MSG_PASSWORD_IS_NOT_CORRECT = 'Password is not correct.';

    const MSG_USER_SUCCESSFULLY_LOGGED_IN = 'User is successfully logged in';
    const MSG_USER_SUCCESSFULLY_LOGGED_OUT = 'User is successfully logged out';
    const MSG_USER_SUCCESSFULLY_REGISTERED = 'User is successfully registered';
    const MSG_PASSWORD_CHANGED = 'Password is successfully changed';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id = null;

    /**
     * @ORM\Column(type="string", length=64, unique=true, nullable=false)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=128)
     * @var string
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=256)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="smallint")
     * @var int
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isEmailConfirmed;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @var null|string
     */
    protected $resetToken;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @var null|string
     */
    protected $emailConfirmToken;

    public function __construct(array $values)
    {
        $this->setEmail($values['email']);
        $this->setFullName($values['fullname']);
        $this->setPassword($values['password']);
        $this->setCreatedAt($values['createdAt'] ?? new \DateTime());
        $this->setUpdatedAt($values['updatedAt'] ?? new \DateTime());
        $this->setStatus($values['status'] ?? UserStatus::STATUS_DISABLE);
        $this->setIsEmailConfirmed($values['isEmailConfirmed'] ?? false);
        $this->setResetToken($values['resetToken'] ?? null);
        $this->setEmailConfirmToken($values['emailConfirmToken'] ?? null);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isEmailConfirmed(): bool
    {
        return $this->isEmailConfirmed;
    }

    /**
     * @param bool $isEmailConfirmed
     */
    public function setIsEmailConfirmed(bool $isEmailConfirmed)
    {
        $this->isEmailConfirmed = $isEmailConfirmed;
    }

    /**
     * @return null|string
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * @param null|string $resetToken
     */
    public function setResetToken(?string $resetToken)
    {
        $this->resetToken = $resetToken;
    }

    /**
     * @return null|string
     */
    public function getEmailConfirmToken(): ?string
    {
        return $this->emailConfirmToken;
    }

    /**
     * @param null|string $emailConfirmToken
     */
    public function setEmailConfirmToken(?string $emailConfirmToken)
    {
        $this->emailConfirmToken = $emailConfirmToken;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName)
    {
        $this->fullName = $fullName;
    }

    protected $client;
    protected $accessToken;
    protected $authorizationCode;
    protected $refreshToken;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
