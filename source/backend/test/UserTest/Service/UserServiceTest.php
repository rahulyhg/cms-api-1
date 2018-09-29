<?php

namespace ModuleTests\UsersTest;

use Doctrine\ORM\EntityManager;
use ModuleTests\Bootstrap;
use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Service\UserService;

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

        // Initialize DB
        $this->haveInDb();
    }

    protected function tearDown()
    {
        $this->userService = null;
        parent::tearDown();
    }

    protected function getORM(): EntityManager
    {
        return Bootstrap::getServiceManager()->get('doctrine.entitymanager.orm_default');
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

    /**
     * @param int|null $singleUserIndex
     * @param bool     $unsaved
     *
     * @return array
     */
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
                    'isActivated' => false,
                    'isEmailConfirmed' => false,
                    'createdAt' => new \DateTime(strtotime('2018-09-22 07:36:13')),
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

    public function testRegisterUserService()
    {
        $user = $this->getUsers(0, true);
        $userObj = $this->userService->registerUser($user['email'], $user['password']);

        $this->assertInstanceOf(User::class, $userObj);
    }

    public function testRegisterUserServiceAlreadyExistsException()
    {
        $user = $this->getUsers(0);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(UserService::ERR_ALREADY_EXISTS_CODE);
        $this->expectExceptionMessage(UserService::ERR_ALREADY_EXISTS_MSG);
        $this->userService->registerUser($user['email'], $user['password']);
    }

    public function fetchUser()
    {
        $userObj = $this->getUsers(0);
        $user = $this->userService->fetchUser($userObj['email']);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testFetchUserNotFoundException()
    {
        $user = $this->getUsers(0, true);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(UserService::ERR_NO_USER_FOUND_CODE);
        $this->expectExceptionMessage(UserService::ERR_NO_USER_FOUND_MSG);
        $this->userService->fetchUser($user['email']);
    }

    public function testResetPassword()
    {
        $user = $this->getUsers(0);
        $userObj = $this->userService->fetchUser($user['email']);

        $newPassword = 'test5678';
        $token = $this->userService->generateActiveCode($userObj);
        $userNewPass = $this->userService->resetPassword($user['email'], $token, $newPassword);

        $this->assertInstanceOf(User::class, $userNewPass);
    }

    public function testResetPasswordInvalidTokenException()
    {
        $user = $this->getUsers(0);

        $newPassword = 'test5678';
        $token = 'invalid token';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(UserService::ERR_INVALID_RESET_TOKEN_CODE);
        $this->expectExceptionMessage(UserService::ERR_INVALID_RESET_TOKEN_MSG);
        $this->userService->resetPassword($user['email'], $token, $newPassword);
    }

    public function testForgotPassword()
    {
        $existedUser = $this->getUsers(0);

        $response = $this->userService->forgotPassword($existedUser['email']);

        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('isMailSend', $response);
        $this->assertTrue($response['isMailSend']);
    }

    private function activateUser()
    {
        $existedUser = $this->getUsers(1);
        $token = $this->userService->generateActiveCode(new User($existedUser));
        // assert that is not active
        $this->userService->activateByEmail($existedUser['email'], $token);
        // assert that is now active

        // assert if already activated
        //exception if user-reset-password email does not exist
        //exception if token is not valid

    }
}
