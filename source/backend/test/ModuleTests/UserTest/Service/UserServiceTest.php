<?php

namespace ModuleTests\UsersTest;

use Doctrine\ORM\EntityManager;
use ModuleTests\Bootstrap;
use PHPUnit\Framework\TestCase;
use UserApi\Entity\User;
use UserApi\Service\UserService;

class UserServiceTest extends TestCase
{
    /**
     * @var UserService
     */
    private $userService;

    protected function setUp()
    {
        parent::setUp();
        $this->userService = Bootstrap::getServiceManager()->get(UserService::class);

        $this->clearDb();

        // Initialize DB
        $this->haveInDb();
    }

    protected function tearDown()
    {
        $this->userService = null;
        parent::tearDown();
    }

    protected function clearDb()
    {
        $orm = $this->getORM();
        $qb = $orm->createQueryBuilder()->select('u');
        $qb->from(User::class, 'u')->andWhere(
            $qb->expr()->like('u.email', ':email')
        );
        $qb->setParameter('email', '%unit_test%');

        $iterateObjRows = $qb->getQuery()->iterate();
        foreach ($iterateObjRows as $rowObj) {
            $orm->remove($rowObj[0]);
        }
        $orm->flush();
        $orm->clear();
    }

    protected function getORM(): EntityManager
    {
        return Bootstrap::getServiceManager()->get(EntityManager::class);
    }

    protected function haveInDb()
    {
        $users = $this->getUsers();
        $emUser = $this->getORM();

        foreach ($users as $user) {
            $emUser->persist(new User($user));
        }
        $emUser->flush();
    }

    protected function getUsers(?int $singleUserIndex = null, bool $unsaved = false): array
    {
        $users = [
            'saved' => [
                [
                    'email' => 'user1+unit_test@email.com',
                    'password' => 'test1234',
                    'createdAt' => new \DateTime(strtotime('2018-09-22 07:36:13')),
                ],
                [
                    'email' => 'user2+unit_test@email.com',
                    'password' => 'test1234',
                    'status' => 0,
                    'isEmailConfirmed' => false,
                    'resetToken' => null,
                    'emailConfirmToken' => null,
                    'createdAt' => new \DateTime(strtotime('2018-09-22 07:36:13')),
                    'updatedAt' => new \DateTime(strtotime('2018-09-22 07:36:13')),
                ],
            ],
            'unsaved' => [
                ['email' => 'new+unit_test@email.com', 'password' => 'test1234'],
            ],
        ];

        $status = $unsaved ? 'unsaved' : 'saved';

        if ($singleUserIndex !== null) {
            return $users[$status][$singleUserIndex];
        }

        return $users[$status];
    }

    public function testGetAllUsers()
    {
        $users = $this->userService->getAll();
        $this->assertCount(2, $users);
    }
}
