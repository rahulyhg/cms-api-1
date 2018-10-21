<?php

namespace MenuApi\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MenuApi\Entity\Menu;

class MenuService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Menu::class);
    }
}
