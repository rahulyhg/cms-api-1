<?php
namespace UserApi\V1\Rpc\SendResetPassword;

use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class SendResetPasswordController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function sendResetPasswordAction()
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $this->userService->getByEmail($data['email'])->sendResetPassword();
            return [
                'success' => true,
                'result' => [],
                'message' => '',
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
    }
}
