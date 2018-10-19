<?php

namespace Application\Service;

use MtMail\Service\Composer;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;

class MailComposer extends Composer
{
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $sem = new SharedEventManager();
            $this->eventManager = new EventManager($sem);
        }

        return $this->eventManager;
    }
}
