<?php

namespace CmsApi\Service;

use Application\Service\Utility;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use CmsApi\Entity\Menu;
use CmsApi\Message\MenuMessage;

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

    /**
     * @param string $name
     * @param string $slug
     * @param string $link
     * @param bool   $enable
     * @param bool   $newWindow
     *
     * @return Menu
     */
    public function create(
        string $name,
        string $slug,
        string $link,
        bool $enable,
        bool $newWindow
    ): Menu {
        /** @var Menu $menu */
        $menu = $this->getRepository()->findOneBy([
            'slug' => $slug,
        ]);

        if (!empty($menu)) {
            throw new \RuntimeException(MenuMessage::ERR_MSG_ALREADY_EXIST, MenuMessage::ERR_CODE_ALREADY_EXIST);
        }

        $menu = new Menu([
            'name' => $name,
            'slug' => $slug,
            'link' => $link,
            'isEnable' => $enable,
            'newWindow' => $newWindow,
        ]);
        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $menu;
    }

    /**
     * @return Menu
     * @internal param int $id
     *
     */
    public function delete(): Menu
    {
        $menu = $this->menu;

        $this->entityManager->remove($menu);
        $this->entityManager->flush();

        return $menu;
    }

    /**
     * Delete a list of ids and return number of successfully deleted records
     *
     * @param int[] $ids
     *
     * @return int
     */
    public function deleteMenus(array $ids): int
    {

        Utility::isArrayOfIds($ids);

        $qb = $this->entityManager->createQueryBuilder();

        /** @var int $result */
        $result = $qb->delete(Menu::class, 'u')
            ->where($qb->expr()->in('u.id', $ids))
            ->getQuery()
            ->execute();

        return $result;
    }

    /**
     * @param array $info
     *
     * @return Menu
     */
    public function edit(array $info): Menu
    {
        $menu = $this->menu;

        $menu->setName($info['name']);
        $menu->setSlug($info['slug']);
        $menu->setLink($info['link']);
        $menu->setIsEnable($info['enable']);
        $menu->setNewWindow($info['newWindow']);
        $menu->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $menu;
    }
}
