<?php
namespace UserApi\V1\Rpc\ResetPaswwordLink;

use UserApi\Entity\User;
use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class ResetPaswwordLinkController extends AbstractActionController
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
                'message' => User::ERR_MSG_IS_NO_ACTIVE,
            ];

            if ($user->getStatus()) {
                $container = new Container('user');
                $container->resetPassword = $user;

                $response = [
                    'success' => true,
                    'result' => ['id' => $user->getId()],
                    'message' => '',
                ];
            }
        } catch (\RuntimeException $e) {
            $response = [
                'success' => false,
                'result' => [],
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }
}
