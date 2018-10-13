<?php
namespace UserApi\V1\Rpc\UserLogout;

class UserLogoutControllerFactory
{
    public function __invoke($controllers)
    {
        return new UserLogoutController();
    }
}
