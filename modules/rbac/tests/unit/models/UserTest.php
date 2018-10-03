<?php

namespace app\modules\rbac\tests\unit\models;

use app\models\user\User;
use app\models\user\Username;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Before tests
     */
    public function _before()
    {
        $this->model = new User();
        $this->model->setUsername(new Username('user'));
        $this->model->generateAccessToken();
        $this->model->generateAuthKey();
        $this->model->save();
    }

    /**
     * After tests
     */
    public function _after()
    {
        User::deleteAll();
    }

    /**
     * Test find user by id success
     */
    public function testFindUserByIdSuccess()
    {
        expect_that($user = User::findIdentity($this->model->getId()->getValue()));
        expect($user->getUserName()->getValue())->equals($this->model->getUserName()->getValue());
    }

    /**
     * Test find user by id failed
     */
    public function testFindUserByIdFailed()
    {
        expect_not(User::findIdentity(999));
    }

    /**
     * Test find user by access token success
     */
    public function testFindUserByAccessTokenSuccess()
    {
        expect_that($user = User::findIdentityByAccessToken($this->model->getAccessToken()->getValue()));
        expect($user->getUserName()->getValue())->equals($this->model->getUserName()->getValue());
    }

    /**
     * Test find user by access token failed
     */
    public function testFindUserByAccessTokenFailed()
    {
        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    /**
     * Test find user by username success
     */
    public function testFindUserByUsernameSuccess()
    {
        expect_that($user = User::findByUsername($this->model->getUserName()->getValue()));
        expect($user->getUserName()->getValue())->equals($this->model->getUserName()->getValue());
    }

    /**
     * Test find user by username failed
     */
    public function testFindUserByUsernameFailed()
    {
        expect_not(User::findByUsername('not-existing'));
    }

    /**
     * Test validate auth_key success
     * @depends testFindUserByUsernameSuccess
     */
    public function testValidateAuthkeySuccess()
    {
        $user = User::findByUsername($this->model->getUserName()->getValue());
        expect_that($user->validateAuthKey($this->model->getAuthKey()));
    }

    /**
     * Test validate auth_key failed
     */
    public function testValidateAuthkeyFailed()
    {
        $user = User::findByUsername($this->model->getUserName()->getValue());
        expect_not($user->validateAuthKey('not-existing'));
    }
}
