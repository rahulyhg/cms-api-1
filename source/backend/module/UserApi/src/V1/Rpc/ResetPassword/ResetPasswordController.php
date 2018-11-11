<?php
namespace UserApi\V1\Rpc\ResetPassword;

use UserApi\Entity\User;
use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class ResetPasswordController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function resetPasswordAction()
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $container = new Container('user');
            if (empty($container->resetPassword) || $container->resetPassword->getId() !== $data['id']) {
                throw new \RuntimeException(User::ERR_MSG_INVALID_PARAMETER, User::ERR_CODE_INVALID_PARAMETER);
            }

            /** @var User $user */
            $user = $container->resetPassword;
            unset($container->resetPassword);

            $this->userService
                ->getByToken($user->getEmail(), $user->getResetToken(),'resetPassword')
                ->resetPassword($data['password']);
            $container->currentUser = $user;

            return [
                'success' => true,
                'result' => [],
                'messageText' => User::MSG_PASSWORD_CHANGED,
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
