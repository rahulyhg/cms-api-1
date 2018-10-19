<?php
namespace PingApi\V1\Rpc\TestEmail;

use Application\Service\AppMail;
use Zend\Mvc\Controller\AbstractActionController;

class TestEmailController extends AbstractActionController
{
    /**
     * @var AppMail
     */
    private $mail;

    public function __construct(
        AppMail $mail
    ) {
        $this->mail = $mail;
    }

    public function testEmailAction()
    {
        $data = $this->params()->fromQuery();

        return [
            'result' => $this->mail->send('ping-api/mail/ping.phtml', $data)
        ];
    }
}
