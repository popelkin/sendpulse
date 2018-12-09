<?php

require_once __DIR__ . '/../../init-tests.php';

use PHPUnit\Framework\TestCase;
use App\Factory;
use App\Models\User;
use App\Models\UserThrottlin;

class AuthServiceTest extends TestCase
{

    public function setUp()
    {
        User::truncate();
        UserThrottlin::truncate();
    }

    public function testRegisterUserSuccess()
    {
        $data = [
            'email' => "test" . time() . "@test.com",
            'password' => 'password',
            'password_confirm' => 'password',
            'signup' => 1,
        ];
        $this->assertTrue(Factory::AuthService()->authorizeUser($data));
    }

    public function testRegisterUserErrorEmail()
    {
        $data = [
            'email' => "incorrect email",
            'password' => 'password',
            'password_confirm' => 'password',
            'signup' => 1,
        ];
        $this->assertIsArray(Factory::AuthService()->authorizeUser($data));
    }

    public function testRegisterUserErrorPassword()
    {
        $data = [
            'email' => "test" . time() . "@test.com",
            'password' => '',
            'password_confirm' => '',
            'signup' => 1,
        ];
        $this->assertIsArray(Factory::AuthService()->authorizeUser($data));
    }

    public function testAuthorizeUserSuccess()
    {
        $data = [
            'email' => "test" . time() . "@test.com",
            'password' => 'password',
            'password_confirm' => 'password',
            'signup' => 1,
        ];
        // adding new user to db
        Factory::AuthService()->authorizeUser($data);

        // truing to login
        $data['signup'] = 0;
        $this->assertTrue(Factory::AuthService()->authorizeUser($data));
    }

    public function testAuthorizeUserErrorPassword()
    {
        $data = [
            'email' => "test" . time() . "@test.com",
            'password' => 'password',
            'password_confirm' => 'password',
            'signup' => 1,
        ];
        // adding new user to db
        Factory::AuthService()->authorizeUser($data);

        // truing to login
        $data['signup'] = 0;
        $data['password'] = 'xxx';
        $result = Factory::AuthService()->authorizeUser($data);

        $this->assertNotEmpty($result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey('password', $result);
    }

    public function testUserAlreadyExists()
    {
        $data = [
            'email' => "test" . time() . "@test.com",
            'password' => 'password',
            'password_confirm' => 'password',
            'signup' => 1,
        ];
        // adding new user to db
        Factory::AuthService()->authorizeUser($data);

        // trying to add again
        $result = Factory::AuthService()->authorizeUser($data);

        $this->assertNotEmpty($result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey('email_exists', $result);
    }

}