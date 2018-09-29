<?php

namespace UserApi\Service;

use UserApi\Entity\User;

interface UserServiceInterface
{
    /**
     * @return User[]
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return null|User
     */
    public function getById(int $id): ?User;

    /**
     * @param int $id
     * @return null|User
     */
    public function delete(int $id): ?User;
}
