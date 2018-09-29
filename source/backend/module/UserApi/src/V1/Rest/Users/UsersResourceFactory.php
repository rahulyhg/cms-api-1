<?php
namespace UserApi\V1\Rest\Users;

use UserApi\Service\UserService;
use Zend\ServiceManager\ServiceManager;

class UsersResourceFactory
{
    public function __invoke(ServiceManager $services)
    {
        $userService = $services->get(UserService::class);
        return new UsersResource($userService);
    }
}
