<?php

namespace UserApi\Service;

use UserApi\Entity\User;

interface UserServiceInterface
{
    /**
     * @return User[]
     */
    public function fetchAll(): array;

    /**
     * @param int $id
     *
     * @return UserService
     */
    public function getById(int $id): UserService;

    /**
     * @return User
     * @internal param int $id
     */
    public function delete(): User;
}
