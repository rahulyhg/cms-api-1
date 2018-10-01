<?php

namespace UserApi\Service;

use UserApi\Entity\User;

class EmailService
{
    public function __construct()
    {
        // initial email
    }

    private function send(User $user)
    {
        $mail = __DIR__.'/../../../../data/mail/test.txt';
        file_put_contents($mail, 'mail');
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function sendConfirmEmailToken(User $user): bool
    {
        $this->send($user);
        return true;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function sendResetPasswordToken(User $user): bool
    {
        $this->send($user);
        return true;
    }
}
