<?php
namespace CmsApi\V1\Rest\Sliders;

use CmsApi\Service\SliderService;
use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class SlidersResource extends AbstractResourceListener
{
    /**
     * @var SliderService
     */
    private $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
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
            $slider = $this->sliderService
                ->create(
                    $data['text'],
                    $data['enable'],
                    basename($data['file']['tmp_name'])
                );
            return [
                'success' => true,
                'result' => $slider,
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
            $result = $this->sliderService
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
            $this->sliderService->deleteSliders($data['ids']);
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
            $slider = $this->sliderService->getById($id)->fetch();
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }

        return $slider;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new SlidersCollection(
            new ArrayAdapter($this->sliderService->fetchAll())
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
            $slider = $this->sliderService
                ->getById($id)
                ->edit([
                    'text' => $data['text'],
                    'image' => basename($data['file']['tmp_name']),
                    'enable' => $data['enable'],
                ]);
            return [
                'success' => true,
                'result' => $slider,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblem(422, $e->getMessage());
        }
    }
}
