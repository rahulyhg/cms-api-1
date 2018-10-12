<?php

namespace UserApi\V1\Rpc\UserLogin;

use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class UserLoginController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function userLoginAction()
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $user = $this->userService->login($data['email'], $data['password']);
            $response = [
                'result' => true,
                'user' => $user,
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(
                new ApiProblem(
                    422, 'Failed Validation', null, null, [
                        'validation_messages' => [
                            'email' => [$e->getMessage()]
                        ]
                ])
            );
        }

        return $response;
    }
}
