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
        $connection = $this->entityManager()->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeUpdate($platform->getTruncateTableSQL('users', true /* whether to cascade */));
    }

    protected function entityManager(): EntityManager
    {
        return Bootstrap::getServiceManager()->get(EntityManager::class);
    }

    protected function haveInDb()
    {
        $users = $this->getUsers();
        $emUser = $this->entityManager();

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
                    'status' => User::STATUS_ENABLE,
                    'isEmailConfirmed' => false,
                    'resetToken' => null,
                    'emailConfirmToken' => null,
                    'createdAt' => new \DateTime(strtotime('2018-09-22 07:36:13')),
                    'updatedAt' => new \DateTime(strtotime('2018-09-22 07:36:13')),
                ],
                ['email'=>'user3@yahoo.com', 'password'=>'123', 'status'=>User::STATUS_ENABLE],
                ['email'=>'user4@yahoo.com', 'password'=>'123', 'status'=>User::STATUS_ENABLE],
            ],
            'unsaved' => [
                ['email' => 'new+unit_test@email.com', 'password' => 'test1234'],
            ],
        ];

        $status = $unsaved ? 'unsaved' : 'saved';

        if ($singleUserIndex !== null) {
            return $users[$status][$singleUserIndex - 1];
        }

        return $users[$status];
    }

    public function testGetAllUsers()
    {
        $fetchUser = $this->getUsers();
        $users = $this->userService->getAll();
        $this->assertCount(count($fetchUser), $users);
    }

    public function testGetUserById()
    {
        $id = 2;
        $fetchUser = $this->getUsers($id);
        /** @var User $user */
        $user = $this->userService->getById($id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($fetchUser['email'], $user->getEmail());
        $this->assertEquals($fetchUser['status'], $user->getStatus());
        $this->assertFalse($user->isEmailConfirmed());
        $this->assertNull($user->getResetToken());
        $this->assertNull($user->getEmailConfirmToken());
        $this->assertEquals($fetchUser['createdAt'], $user->getCreatedAt());
        $this->assertEquals($fetchUser['updatedAt'], $user->getUpdatedAt());
    }

    public function testGetUserByEmail()
    {
        $id = 1;
        $fetchUser = $this->getUsers($id);
        /** @var User $user */
        $user = $this->userService->getByEmail($fetchUser['email']);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($fetchUser['email'], $user->getEmail());
    }

    public function testGetAllUsersByStatusActive()
    {
        /** @var User[] $users */
        $users = $this->userService->getByStatus(User::STATUS_ENABLE);

        $this->count(3, $users);
        $this->assertInstanceOf(User::class, $users[0]);
    }
}
