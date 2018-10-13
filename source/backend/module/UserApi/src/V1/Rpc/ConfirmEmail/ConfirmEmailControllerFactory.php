<?php
namespace UserApi\V1\Rpc\ConfirmEmail;

class ConfirmEmailControllerFactory
{
    public function __invoke($controllers)
    {
        return new ConfirmEmailController();
    }
}
