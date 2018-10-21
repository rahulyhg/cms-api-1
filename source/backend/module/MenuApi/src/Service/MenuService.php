<?php

namespace MenuApi\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MenuApi\Entity\Menu;
use MenuApi\Message\MenuMessage;

class MenuService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Menu
     */
    private $menu;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Menu::class);
    }

    /**
     * @param int $id
     *
     * @return MenuService
     * @internal param bool $exception
     *
     */
    public function getById(int $id): MenuService
    {
        /** @var Menu $menu */
        $menu = $this->getRepository()->find($id);

        if (empty($menu)) {
            throw new \RuntimeException(MenuMessage::ERR_MSG_NOT_FOUND, MenuMessage::ERR_CODE_NOT_FOUND);
        }

        $this->menu = $menu;
        return $this;
    }

    /**
     * @return Menu[]
     */
    public function fetchAll(): array
    {
        $menus = $this->getRepository()->findAll();
        return $menus;
    }

    /**
     * @return Menu
     */
    public function fetch(): Menu
    {
        return $this->menu;
    }
}
