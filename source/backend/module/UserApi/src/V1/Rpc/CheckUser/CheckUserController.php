<?php
namespace UserApi\V1\Rpc\CheckUser;

use UserApi\Entity\User;
use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;

class CheckUserController extends AbstractActionController
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

    public function checkUserAction()
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = $this->userService->getAuthenticatedIdentity();
        return [
            'success' => true,
            'result' =>  [
                'id' => $authenticatedUser->getId(),
                'email' => $authenticatedUser->getEmail(),
                'fullName' => $authenticatedUser->getFullName(),
            ],
            'messageText' => '',
        ];
    }
}
