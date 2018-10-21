<?php
namespace UserApi\V1\Rest\Users;

use Application\Service\Utility;
use UserApi\Service\UserService;
use Zend\Paginator\Adapter\ArrayAdapter;
use ArrayObject;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UsersResource extends AbstractResourceListener
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try {
            $user = $this->userService
                ->addUserByAdmin(
                    $data->email,
                    $data->fullname,
                    Utility::randomPassword()
                );
            return [
                'success' => true,
                'result' => $user,
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
        $result = $this->userService
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
            $this->userService->deleteUsers($data['ids']);
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return true;
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        try {
            $user = $this->userService->getById($id)->changeStatus($data->status)->fetch();
            return [
                'success' => true,
                'result' => $user,
                'message' => '',
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        /** @var ArrayObject $data */
        $ids = array_keys((array)$data);
        $status = $data->getIterator()->current()['status'];

        try {
            $this->userService->changeStatusUsers($ids ,$status);
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return true;
    }

    /**
     * Get a user
     */
    public function fetch($id)
    {
        $user = $this->userService->getById($id)->fetch();
        if (!$user) {
            return new ApiProblem(404, 'User not find');
        }
        return $user;
    }

    /**
     * Get list of users
     */
    public function fetchAll($params = [])
    {
        return new UsersCollection(
            new ArrayAdapter($this->userService->fetchAll())
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
            $user = $this->userService
                ->getById($id)
                ->edit([
                    'fullname' => $data->fullname,
                    'email' => $data->email,
                ]);
            return [
                'success' => true,
                'result' => $user,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }
}
