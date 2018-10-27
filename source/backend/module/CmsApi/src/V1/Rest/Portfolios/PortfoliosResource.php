<?php
namespace CmsApi\V1\Rest\Portfolios;

use CmsApi\Service\PortfolioService;
use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class PortfoliosResource extends AbstractResourceListener
{
    /**
     * @var PortfolioService
     */
    private $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
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
            $portfolio = $this->portfolioService
                ->create(
                    $data['title'],
                    $data['link'],
                    $data['text'],
                    $data['published'],
                    basename($data['file']['tmp_name'])
                );
            return [
                'success' => true,
                'result' => $portfolio,
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
            $result = $this->portfolioService
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
            $this->portfolioService->deletePosts($data['ids']);
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
            $portfolio = $this->portfolioService->getById($id)->fetch();
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return $portfolio;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new PortfoliosCollection(
            new ArrayAdapter($this->portfolioService->fetchAll())
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
            $portfolio = $this->portfolioService
                ->getById($id)
                ->edit([
                    'text' => $data['text'],
                    'image' => basename($data['file']['tmp_name']),
                    'enable' => $data['enable'],
                ]);
            return [
                'success' => true,
                'result' => $portfolio,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }
}
