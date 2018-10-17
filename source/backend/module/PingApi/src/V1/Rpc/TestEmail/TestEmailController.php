<?php
namespace PingApi\V1\Rpc\TestEmail;

use UserApi\Service\EmailService;
use Zend\Mvc\Controller\AbstractActionController;

class TestEmailController extends AbstractActionController
{
    /**
     * @var EmailService
     */
    private $mail;

    public function __construct(
        EmailService $mail
    ) {
        $this->mail = $mail;
    }

    public function testEmailAction()
    {
        $data = $this->params()->fromQuery();

        return [
            'result' => $this->mail->sendTestEmail($data)
        ];
    }
}
