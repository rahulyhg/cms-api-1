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
     */
    protected $id = null;

    /**
     * @ORM\Column(type="string", length=64, unique=true, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isEmailConfirmed;

    /**
     * @ORM\Column(type="string", length=256, nullable=false)
     */
    protected $resetToken;

    /**
     * @ORM\Column(type="string", length=256, nullable=false)
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
}
