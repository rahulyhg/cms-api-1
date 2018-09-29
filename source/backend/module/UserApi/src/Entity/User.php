<?php
namespace UserApi\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 * References for Doctrine ORM Entity:
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/annotations-reference.html#index
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.4/reference/basic-mapping.html#doctrine-mapping-types
 */
class User
{
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

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->status = 0;
        $this->isEmailConfirmed = false;
        $this->resetToken = null;
        $this->emailConfirmToken = null;
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
     * @param string $resetToken
     */
    public function setResetToken(string $resetToken)
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
     * @param string $emailConfirmToken
     */
    public function setEmailConfirmToken($emailConfirmToken)
    {
        $this->emailConfirmToken = $emailConfirmToken;
    }
}
