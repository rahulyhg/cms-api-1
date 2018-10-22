<?php

namespace CmsApi\Entity;

use CmsApi\Type\SliderStatus;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="slider")
 *
 * References for Doctrine ORM Entity:
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/annotations-reference.html#index
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.4/reference/basic-mapping.html#doctrine-mapping-types
 */
class Slider
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var null|string
     */
    protected $text;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isEnable;

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
        $this->setText($values['text']);
        $this->setIsEnable($values['isEnable'] ?? SliderStatus::PUBLISHED);
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
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param null|string $text
     */
    public function setText($text)
    {
        $this->text = $text;
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
