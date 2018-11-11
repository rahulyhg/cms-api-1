<?php
namespace UserApi\V1\Rpc\UserLogout;

use UserApi\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class UserLogoutController extends AbstractActionController
{
    public function userLogoutAction()
    {
        $container = new Container('user');
        unset($container->currentUser);
        return [
            'success' => true,
            'result' => [],
            'messageText' => User::MSG_USER_SUCCESSFULLY_LOGGED_OUT
        ];
    }
}
