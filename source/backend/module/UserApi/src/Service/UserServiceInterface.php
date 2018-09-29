<?php

namespace UserApi\Service;

use UserApi\Entity\User;

interface UserServiceInterface
{
    /**
     * @return User[]
     */
    public function getAll(): array;
}
