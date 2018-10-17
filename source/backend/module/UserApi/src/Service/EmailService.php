<?php

namespace UserApi\Service;

use MtMail\Service\Mail as MtMail;
use UserApi\Entity\User;

class EmailService
{
    /**
     * @var MtMail
     */
    private $mtMail;

    public function __construct(
        ?MtMail $mtMail
    ) {
        $this->mtMail = $mtMail;
    }

    private function send(User $user, string $template): bool
    {
        if (defined('TEST_ENV')) {
            $mail = __DIR__.'/../../../../data/mail/ '.$template.'.txt';
            file_put_contents($mail, 'mail');
            return true;
        }
        return true;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function sendTestEmail(array $data): bool
    {
        $template = 'application/mail/ping.phtml';
        $headers = [
            'to' => 'johndoe@domain.com',
        ];
        $message = $this->mtMail->compose($headers, $template, $data);
        $this->mtMail->send($message);
        return true;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function sendConfirmEmailToken(User $user): bool
    {
        $this->send($user, 'application/mail/confirm-email.phtml');
        return true;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function sendResetPasswordToken(User $user): bool
    {
        $this->send($user, 'application/mail/reset-password.phtml');
        return true;
    }
}
