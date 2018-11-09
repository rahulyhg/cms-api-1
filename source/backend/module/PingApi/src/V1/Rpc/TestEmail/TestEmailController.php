<?php
namespace PingApi\V1\Rpc\TestEmail;

use Zend\Mvc\Controller\AbstractActionController;

class TestEmailController extends AbstractActionController
{
    public function testEmailAction()
    {
        return [
            'result' => 'Ping . . ...'
        ];
    }
}
