<?php
namespace UserApi\V1\Rpc\CheckUser;

class CheckUserControllerFactory
{
    public function __invoke($controllers)
    {
        return new CheckUserController();
    }
}
