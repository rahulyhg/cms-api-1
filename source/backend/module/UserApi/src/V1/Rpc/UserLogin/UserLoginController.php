<?php

namespace UserApi\V1\Rpc\UserLogin;

use UserApi\Entity\User;
use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class UserLoginController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function userLoginAction()
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $user = $this->userService->login($data['email'], $data['password']);
            $container = new Container('user');
            $container->currentUser = $user;
            $response = [
                'success' => true,
                'result' => [$user->getId()],
                'message' => User::MSG_USER_SUCCESSFULLY_LOGGED_IN
            ];
        } catch (\RuntimeException $e) {
            return new ApiProblemResponse(
                new ApiProblem(
                    422, 'Failed Validation', null, null, [
                    'validation_messages' => [
                        'email' => [$e->getMessage()],
                    ],
                ])
            );
        }

        return $response;
    }
}
