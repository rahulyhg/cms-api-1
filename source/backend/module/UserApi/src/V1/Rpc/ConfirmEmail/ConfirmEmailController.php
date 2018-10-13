<?php
namespace UserApi\V1\Rpc\ConfirmEmail;

use Zend\Mvc\Controller\AbstractActionController;

class ConfirmEmailController extends AbstractActionController
{
    public function confirmEmailAction()
    {
        $ee = $this->params()->fromRoute('email', 0);
        var_dump($ee);
        die();
        return [
            'success' => true
        ];
    }
}
