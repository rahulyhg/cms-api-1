<?php
namespace UserApi\V1\Rpc\ActivateAccount;

use UserApi\Service\UserService;
use UserApi\Type\UserStatus;
use Zend\Mvc\Controller\AbstractActionController;

class ActivateAccountController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function activateAccountAction()
    {
        $email = $this->params()->fromRoute('email', null);
        $token = $this->params()->fromRoute('token', null);

        try {
            $this->userService
                ->getByToken($email, $token,'emailConfirm')
                ->confirmEmail()
                ->changeStatus(UserStatus::STATUS_ENABLE);
            $response = [
                'success' => true,
                'result' => [],
                'message' => '',
            ];
        } catch (\RuntimeException $e) {
            $response = [
                'success' => false,
                'result' => [],
                'message' => $e->getMessage(),
            ];
        }

        // TODO create new class to generate the response array
        return $response;
    }
}
