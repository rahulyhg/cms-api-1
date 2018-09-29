<?php
namespace UserApi\V1\Rest\Users;

use DoctrineModule\Validator\ObjectExists;
use UserApi\Service\UserServiceInterface;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Validator;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UsersResource extends AbstractResourceListener
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
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
        die('create user');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        die('delete one user');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        die('delete all user');
    }

    /**
     * Get a user
     */
    public function fetch($id)
    {
        $user = $this->userService->getById($id);
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
            new ArrayAdapter($this->userService->getAll())
        );
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return [
            'result' => 'edit all user'
        ];
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
        return [
            'result' => 'update user'
        ];
    }
}
