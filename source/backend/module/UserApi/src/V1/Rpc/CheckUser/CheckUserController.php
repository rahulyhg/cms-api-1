<?php
namespace UserApi\V1\Rpc\CheckUser;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class CheckUserController extends AbstractActionController
{
    public function checkUserAction()
    {
        $container = new Container('user');
        return [
            'success' => (bool) $container->currentUser,
            'result' => $container->currentUser ? [
                'id' => $container->currentUser->getId(),
                'email' => $container->currentUser->getEmail(),
            ] : [],
            'message' => '',
        ];
    }
}
