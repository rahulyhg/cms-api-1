<?php
namespace UserApi\V1\Rpc\ConfirmEmail;

use UserApi\Service\UserService;
use UserApi\Type\UserStatus;
use Zend\Mvc\Controller\AbstractActionController;

class ConfirmEmailController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function confirmEmailAction()
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

        // TODO create new mapper class to generate this response
        return $response;
    }
}
