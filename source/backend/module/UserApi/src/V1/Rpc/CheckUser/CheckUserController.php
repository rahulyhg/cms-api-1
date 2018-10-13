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
            'success' => isset($container->currentUser),
            'result' => [],
            'message' => '',
        ];
    }
}
