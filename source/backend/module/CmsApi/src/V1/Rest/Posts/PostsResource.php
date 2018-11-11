<?php
namespace CmsApi\V1\Rest\Posts;

use CmsApi\Service\PostService;
use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use ZF\Rest\AbstractResourceListener;

class PostsResource extends AbstractResourceListener
{
    /**
     * @var PostService
     */
    private $blogService;

    public function __construct(PostService $blogService)
    {
        $this->blogService = $blogService;
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
            $blog = $this->blogService
                ->create(
                    $data['title'],
                    $data['text'],
                    $data['published'],
                    basename($data['file']['tmp_name'])
                );
            return [
                'success' => true,
                'result' => $blog,
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
            $result = $this->blogService
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
            $this->blogService->deletePosts($data['ids']);
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return true;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try {
            $blog = $this->blogService->getById($id)->fetch();
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return $blog;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if($this->getIdentity() instanceof AuthenticatedIdentity) {
            $fetch = $this->blogService->fetchAll();
        } else {
            $fetch = $this->blogService->fetchAllPublished();
        }

        return new PostsCollection(
            new ArrayAdapter($fetch)
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
        $data = $this->getInputFilter()->getValues();

        try {
            $blog = $this->blogService
                ->getById($id)
                ->edit([
                    'text' => $data['text'],
                    'image' => basename($data['file']['tmp_name']),
                    'enable' => $data['enable'],
                ]);
            return [
                'success' => true,
                'result' => $blog,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }
}
