<?php

namespace CmsApi\Entity;

use Doctrine\ORM\Mapping as ORM;
use CmsApi\Type\MenuStatus;

/**
 * @ORM\Entity
 * @ORM\Table(name="menus")
 *
 * References for Doctrine ORM Entity:
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/annotations-reference.html#index
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.4/reference/basic-mapping.html#doctrine-mapping-types
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id = null;

    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @var null|string
     */
    protected $link;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isEnable;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $newWindow;

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

    public function __construct(array $values)
    {
        $this->setName($values['name']);
        $this->setSlug($values['slug']);
        $this->setLink($values['link']);
        $this->setIsEnable($values['isEnable'] ?? MenuStatus::DISABLE);
        $this->setNewWindow($values['newWindow'] ?? false);
        $this->setCreatedAt($values['createdAt'] ?? new \DateTime());
        $this->setUpdatedAt($values['updatedAt'] ?? new \DateTime());
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return null|string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param null|string $link
     */
    public function setLink(?string $link)
    {
        $this->link = $link;
    }

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->isEnable;
    }

    /**
     * @param bool $isEnable
     */
    public function setIsEnable(bool $isEnable)
    {
        $this->isEnable = $isEnable;
    }

    /**
     * @return bool
     */
    public function isNewWindow(): bool
    {
        return $this->newWindow;
    }

    /**
     * @param bool $newWindow
     */
    public function setNewWindow(bool $newWindow)
    {
        $this->newWindow = $newWindow;
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
}
