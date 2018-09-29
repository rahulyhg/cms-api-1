<?php
namespace UserApi\V1\Rpc\UserExist;

class UserExistControllerFactory
{
    public function __invoke($controllers)
    {
        return new UserExistController();
    }
}
