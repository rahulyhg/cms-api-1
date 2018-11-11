<?php

namespace UserApi\Initializer;

use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Initializer\InitializerInterface;
use UserApi\Entity\User;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use UserApi\Authentication\iAuthAwareInterface;
use ZF\ApiProblem\ApiProblem;

class iAuthAwareInitializer implements InitializerInterface
{
    /**
     * Initialize the given instance
     *
     * @param  ContainerInterface $container
     * @param  object             $instance
     *
     * @return void|ApiProblem
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if ($instance instanceof iAuthAwareInterface) {
            try {
                $authObj = $container->get('api-identity');

                if ($authObj instanceof AuthenticatedIdentity) {
                    /**
                     * @var $orm EntityManagerInterface
                     */
                    $orm = $container->get('doctrine.entitymanager.orm_default');
                    $oauth_user_id = $container->get('api-identity')->getAuthenticationIdentity()['user_id'];

                    /** @var User $userObj */
                    $userObj = $orm->find(User::class, $oauth_user_id);

                    $instance->setAuthenticatedIdentity($userObj);
                }
            } catch (\exception $e) {
                return new ApiProblem(500, $e->getMessage());
            }
        }
    }
}
