<?php
namespace UserApi\V1\Rpc\ResetPasswordLink;

use UserApi\Entity\User;
use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class ResetPasswordLinkController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function resetPaswwordLinkAction()
    {
        $email = $this->params()->fromRoute('email', null);
        $token = $this->params()->fromRoute('token', null);

        try {
            $user = $this->userService
                ->getByToken($email, $token,'resetPassword')
                ->fetch();


            $response = [
                'success' => false,
                'result' => [],
                'messageText' => User::ERR_MSG_IS_NO_ACTIVE,
            ];

            if ($user->getStatus()) {
                $container = new Container('user');
                $container->resetPassword = $user;

                $response = [
                    'success' => true,
                    'result' => ['id' => $user->getId()],
                    'messageText' => '',
                ];
            }
        } catch (\RuntimeException $e) {
            $response = [
                'success' => false,
                'result' => [],
                'messageText' => $e->getMessage(),
            ];
        }

        return $response;
    }
}
