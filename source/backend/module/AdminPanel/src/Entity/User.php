<?php

namespace AdminPanel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=128,unique=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string",length=74)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"}))
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isEmailConfirmed;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isActivated;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    protected $roles;

    // oAuth
    protected $client;
    protected $accessToken;
    protected $authorizationCode;
    protected $refreshToken;
}
