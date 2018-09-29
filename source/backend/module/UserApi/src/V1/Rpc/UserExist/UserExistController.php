<?php
namespace UserApi\V1\Rpc\UserExist;

use Zend\Mvc\Controller\AbstractActionController;

class UserExistController extends AbstractActionController
{
    public function userExistAction()
    {
//        var_dump($this->params()->fromRoute('id'));
        return [
            'result' => true
        ];
    }
}
