<?php

namespace UserApi\Authentication;

use UserApi\Entity\User;
use Zend\Authentication\AuthenticationServiceInterface;

interface iAuthAwareInterface
{
    /**
     * @param User $user
     *
     * @return
     * @internal param AuthenticationServiceInterface $authService
     */
    public function setAuthenticatedIdentity(User $user);

    /**
     *
     * @return User
     * @throws InvalidIdentityException
     */
    public function getAuthenticatedIdentity();
}
