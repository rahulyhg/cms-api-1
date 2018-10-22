<?php
namespace UserApi\V1\Rest\Sliders;

class SlidersResourceFactory
{
    public function __invoke($services)
    {
        return new SlidersResource();
    }
}
