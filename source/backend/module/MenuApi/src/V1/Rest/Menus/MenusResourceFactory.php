<?php
namespace MenuApi\V1\Rest\Menus;

class MenusResourceFactory
{
    public function __invoke($services)
    {
        return new MenusResource();
    }
}
