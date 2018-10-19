<?php

namespace Application\Service;


use MtMail\Service\Mail;
use UserApi\Entity\User;
use Zend\Hydrator\Reflection as ReflectionHydrator;

class AppMail
{
    /**
     * @var Mail
     */
    private $mtMail;

    public function __construct(
        Mail $mtMail
    ) {
        $this->mtMail = $mtMail;
    }

    /**
     * @param string $template
     * @param string $subject
     * @param string $to
     * @param User|array  $data
     *
     * @return bool
     */
    public function send(string $template, string $subject, string $to, $data = []): bool
    {
        if ($data instanceof User) {
            $hydrator = new ReflectionHydrator();
            $data = $hydrator->extract($data);
        }

        $headers = [
            'to' => $to,
            'subject' => $subject,
        ];
        $message = $this->mtMail->compose($headers, $template, $data);
        $this->mtMail->send($message);
        return true;
    }
}
