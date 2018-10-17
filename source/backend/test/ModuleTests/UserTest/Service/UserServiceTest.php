<?php

namespace ModuleTests\UsersTest;

use ModuleTests\Bootstrap;
use MtMail\Factory\MailServiceFactory;
use MtMail\Service\Mail;
use PDO;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;
use UserApi\Entity\User;
use UserApi\Service\UserService;
use UserApi\Type\UserStatus;
use Zend\Mvc\View\Http\ViewManager;
use Zend\View\View;

class UserServiceTest extends TestCase
{
    use TestCaseTrait;

    /**
     * @var UserService
     */
    static private $userService;

    /** @var PDO */
    static private $pdo = null;

    /** @var  DefaultConnection */
    private $conn;

    /**
     * @return null|Connection
     */
    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(APPLICATION_PATH.'/test/_files/users-seed.xml');
    }

    public static function setUpBeforeClass()
    {
        self::$userService = Bootstrap::getServiceManager()->get(UserService::class);
    }

    public static function tearDownAfterClass()
    {
        self::$userService = null;
    }

    private function expectedUser(int $id): array
    {
        $user = $this->getDataSet()->getTable("users");

        return [
            'id' => $id,
            'email' => $user->getValue($id - 1, 'email'),
            'fullname' => $user->getValue($id - 1, 'fullname'),
            'password' => $user->getValue($id - 1, 'password'),
            'status' => $user->getValue($id - 1, 'status'),
            'emailConfirmToken' => $user->getValue($id - 1, 'emailConfirmToken') ?: null,
            'isEmailConfirmed' => $user->getValue($id - 1, 'isEmailConfirmed') ?: false,
            'resetToken' => $user->getValue($id - 1, 'resetToken') ?: null,
            'createdAt' => new \DateTime($user->getValue($id - 1, 'createdAt')),
            'updatedAt' => new \DateTime($user->getValue($id - 1, 'updatedAt')),
        ];
    }

    public function testGetAllUsers()
    {
        $expectedRows = $this->getDataSet()->getTable("users")->getRowCount();
        $users = self::$userService->getAll();
        $this->assertCount($expectedRows, $users);
    }

    public function testGetUserById()
    {
        $id = 2;
        $expectedUser = $this->expectedUser($id);

        /** @var User $user */
        $user = self::$userService->getById($id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($expectedUser['email'], $user->getEmail());
        $this->assertEquals($expectedUser['status'], $user->getStatus());
        $this->assertFalse($user->isEmailConfirmed());
        $this->assertNull($user->getResetToken());
        $this->assertNull($user->getEmailConfirmToken());
        $this->assertEquals($expectedUser['createdAt'], $user->getCreatedAt());
        $this->assertEquals($expectedUser['updatedAt'], $user->getUpdatedAt());
    }

    public function testGetUserByEmail()
    {
        $id = 1;
        $expectedUser = $this->expectedUser($id);
        /** @var User $user */
        $user = self::$userService->getByEmail($expectedUser['email']);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($id, $user->getId());
    }

    public function testGetAllUsersByStatusActive()
    {
        /** @var User[] $users */
        $users = self::$userService->getByStatus(UserStatus::STATUS_ENABLE);

        $this->count(3, $users);
        $this->assertInstanceOf(User::class, $users[0]);
    }

    public function testAddUserByAdmin()
    {
        $newUser = [
            'email' => 'shahrokh@email.com',
            'fullname' => 'shahrokh',
            'password' => 'test1234',
        ];

        $beforeRows = $this->getDataSet()->getTable("users")->getRowCount();
        $this->assertEquals($beforeRows, $this->getConnection()->getRowCount('users'));

        $user = self::$userService->addUserByAdmin($newUser['email'], $newUser['fullname'], $newUser['password']);

        $this->assertEquals($beforeRows + 1, $this->getConnection()->getRowCount('users'));
        $this->assertEquals($newUser['email'], $user->getEmail());
        $this->assertEquals($newUser['fullname'], $user->getFullname());
        $this->assertEquals(UserStatus::STATUS_ENABLE, $user->getStatus());

        $this->assertTrue(self::$userService->isPasswordCorrect($newUser['password'], $user->getPassword()));
    }

    public function testRegisterUser()
    {
        $newUser = [
            'email' => 'shahrokh@email.com',
            'fullname' => 'shahrokh',
            'password' => 'test1234',
        ];

        $user = self::$userService->register($newUser['email'], $newUser['fullname'], $newUser['password']);
        $this->assertEquals(UserStatus::STATUS_DISABLE, $user->getStatus());
    }

    public function testCreateUserExceptionAlreadyExist()
    {
        $existedUser = $this->expectedUser(1);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_ALREADY_EXIST);
        self::$userService->addUserByAdmin($existedUser['email'], $existedUser['fullname'], $existedUser['password']);
    }

    public function testDeleteUserById()
    {
        $existedUser = $this->expectedUser(1);

        $sql = 'SELECT * FROM users WHERE id = '.$existedUser['id'];
        $queryTable = $this->getConnection()->createQueryTable('users', $sql);
        $this->assertEquals(1, $queryTable->getRowCount());

        $deletedUser = self::$userService->delete($existedUser['id']);

        $this->assertInstanceOf(User::class, $deletedUser);
        $queryTable = $this->getConnection()->createQueryTable('users', $sql);
        $this->assertEquals(0, $queryTable->getRowCount());
    }

    public function testDeleteUserByInvalidId()
    {
        $deletedUser = self::$userService->delete(0);
        $this->assertNull($deletedUser);
    }

    public function testDeleteListOfUsers()
    {
        $beforeRows = $this->getDataSet()->getTable("users")->getRowCount();
        $this->assertEquals($beforeRows, $this->getConnection()->getRowCount('users'));

        $deleteIds = [1, 2, 3];
        $users = self::$userService->deleteUsers($deleteIds);

        $count = count($deleteIds);
        $this->assertCount($count, $users);
        $this->assertEquals($beforeRows - $count, $this->getConnection()->getRowCount('users'));
    }

    public function testDeleteListExceptionInvalidIds()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_INVALID_PARAMETER);
        self::$userService->deleteUsers([true, '', [2, 1]]);
    }

    public function testChangeUserStatusExceptionNotFound()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_NOT_FOUND);
        self::$userService->changeStatus(100, UserStatus::STATUS_ENABLE);
    }

    public function testChangeUserStatusExceptionWrongStatus()
    {
        $existedUser = $this->expectedUser(1);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_WRONG_STATUS);
        self::$userService->changeStatus($existedUser['id'], 200);
    }

    public function testChangeStatusListOfUsers()
    {
        $sql = 'SELECT * FROM users WHERE status = '.UserStatus::STATUS_ENABLE;
        $enabledUsers = $this->getConnection()->createQueryTable('users', $sql)->getRowCount();

        $changeIds = [1, 4];
        $users = self::$userService->changeStatusUsers($changeIds, UserStatus::STATUS_ENABLE);

        $count = count($changeIds);
        $this->assertCount($count, $users);
        $this->assertEquals(
            $enabledUsers + $count,
            $this->getConnection()->createQueryTable('users', $sql)->getRowCount()
        );
    }

    public function testChangeUserStatus()
    {
        $existedUser = $this->expectedUser(1);
        $this->assertEquals(UserStatus::STATUS_DISABLE, $existedUser['status']);

        $user = self::$userService->changeStatus($existedUser['id'], UserStatus::STATUS_ENABLE);
        $this->assertEquals(UserStatus::STATUS_ENABLE, $user->getStatus());
    }

    public function testSendConfirmEmail()
    {
        $existedUser = $this->expectedUser(1);
        $this->assertNull($existedUser['emailConfirmToken']);

        self::$userService->sendConfirmEmail($existedUser['email']);

        $user = self::$pdo->query('SELECT * FROM users WHERE id = '.$existedUser['id'])->fetch();
        $this->assertNotNull($user['emailConfirmToken']);
    }

    public function testSendResetPassword()
    {
        $existedUser = $this->expectedUser(1);
        $this->assertNull($existedUser['resetToken']);

        self::$userService->sendResetPassword($existedUser['email']);

        $user = self::$pdo->query('SELECT * FROM users WHERE id = '.$existedUser['id'])->fetch();
        $this->assertNotNull($user['resetToken']);
    }

    public function testResetPassword()
    {
        $existedUser = $this->expectedUser(6);
        $this->assertNotEmpty($existedUser['resetToken']);
        $this->assertTrue(self::$userService->isPasswordCorrect('test1234', $existedUser['password']));

        $newPassword = 'test5678';
        self::$userService->resetPassword($existedUser['email'], $existedUser['resetToken'], $newPassword);

        $user = self::$pdo->query('SELECT * FROM users WHERE id = '.$existedUser['id'])->fetch();
        $this->assertTrue(self::$userService->isPasswordCorrect($newPassword, $user['password']));
        $this->assertNull($user['resetToken']);
    }

    public function testConfirmEmail()
    {
        $existedUser = $this->expectedUser(6);
        $this->assertNotEmpty($existedUser['emailConfirmToken']);
        $this->assertFalse($existedUser['isEmailConfirmed']);

        self::$userService->confirmEmail($existedUser['email'], $existedUser['emailConfirmToken']);

        $user = self::$pdo->query('SELECT * FROM users WHERE id = '.$existedUser['id'])->fetch();
        $this->assertTrue((bool)$user['isEmailConfirmed']);
        $this->assertNull($user['emailConfirmToken']);
    }

    public function testGetByTokenExceptionInvalidTypeParams()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_INVALID_PARAMETER);
        self::$userService->getByToken('test@email.com', 'someToken', 'wrongType');
    }

    public function testLoginExceptionUserNotActive()
    {
        $existedUser = $this->expectedUser(6);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_IS_NO_ACTIVE);
        self::$userService->login($existedUser['email'], 'test1234');
    }

    public function testLogin()
    {
        $existedUser = $this->expectedUser(5);

        $user = self::$userService->login($existedUser['email'], 'test1234');
        $this->assertInstanceOf(User::class, $user);
    }

    public function testLoginExceptionEmailNotConfirm()
    {
        $existedUser = $this->expectedUser(3);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_EMAIL_IS_NOT_CONFIRMED);
        self::$userService->login($existedUser['email'], 'test1234');
    }

    public function testLoginExceptionWrongPassword()
    {
        $existedUser = $this->expectedUser(5);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(User::ERR_CODE_PASSWORD_IS_NOT_CORRECT);
        self::$userService->login($existedUser['email'], 'test');
    }

    public function testEditUser()
    {
        $id = 5;
        $existedUser = $this->expectedUser($id);
        $editInfo = [
            'email' => 'user5-edited@email.com',
            'password' => 'test789'
        ];

        $this->assertNotEquals($editInfo['email'], $existedUser['email']);
        $this->assertFalse(self::$userService->isPasswordCorrect($editInfo['password'], $existedUser['password']));

        $user = self::$userService->edit($id, $editInfo);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($editInfo['email'], $user->getEmail());
        $this->assertTrue(self::$userService->isPasswordCorrect($editInfo['password'], $user->getPassword()));
    }
}
