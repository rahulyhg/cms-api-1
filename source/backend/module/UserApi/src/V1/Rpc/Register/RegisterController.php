<?php
namespace UserApi\V1\Rpc\Register;

use UserApi\Entity\User;
use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class RegisterController extends AbstractActionController
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

    public function registerAction()
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $user = $this->userService->register($data['email'], $data['fullname'], $data['password']);
            $response = [
                'success' => true,
                'result' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'fullname' => $user->getFullname(),
                ],
                'message' => User::MSG_USER_SUCCESSFULLY_REGISTERED
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
