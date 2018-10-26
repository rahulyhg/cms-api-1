<?php
namespace CmsApi\V1\Rest\Menus;

use CmsApi\Service\MenuService;
use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class MenusResource extends AbstractResourceListener
{
    /**
     * @var MenuService
     */
    private $menuService;

    public function __construct(MenuService $userService)
    {
        $this->menuService = $userService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $menu = $this->menuService
                ->create(
                    $data['name'],
                    $data['slug'],
                    $data['link'],
                    $data['enable'],
                    $data['newWindow']
                );
            return [
                'success' => true,
                'result' => $menu,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            $result = $this->menuService
                ->getById($id)
                ->delete();
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return (bool) $result;
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        if (!array_key_exists('ids', $data)) {
            return new ApiProblem(400, 'Bad Request');
        }

        try {
            $this->menuService->deleteMenus($data['ids']);
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return true;
    }


    /**
     * Get a Menu
     */
    public function fetch($id)
    {
        try {
            $menu = $this->menuService->getById($id)->fetch();
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return $menu;
    }

    /**
     * Get list of menus
     */
    public function fetchAll($params = [])
    {
        return new MenusCollection(
            new ArrayAdapter($this->menuService->fetchAll())
        );
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        try {
            $menu = $this->menuService
                ->getById($id)
                ->edit([
                    'name' => $data->name,
                    'slug' => $data->slug,
                    'link' => $data->link,
                    'enable' => $data->enable,
                    'newWindow' => $data->newWindow,
                ]);
            return [
                'success' => true,
                'result' => $menu,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }
}
