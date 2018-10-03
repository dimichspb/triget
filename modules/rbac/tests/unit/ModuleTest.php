<?php
namespace app\modules\rbac\tests\unit;

use app\models\user\User;
use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\Module;
use Codeception\Test\Unit;

class ModuleTest extends Unit
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * Before tests
     */
    public function _before()
    {
        $this->module = \Yii::$app->getModule('rbac');
    }

    /**
     * After tests
     */
    public function _after()
    {
        User::deleteAll();
    }

    /**
     * Test create user success
     */
    public function testCreateUserSuccess()
    {
        $user = $this->module->createUser('user');

        expect($user)->isInstanceOf(User::class);
        expect($user->hasErrors())->false();
        expect($user->getId()->getValue())->notNull();
    }

    /**
     * Test get user success
     * @depends testCreateUserSuccess
     */
    public function testGetUserSuccess()
    {
        $user = $this->module->createUser('user');

        $found = $this->module->getUser($user->getUsername()->getValue());

        expect($found)->isInstanceOf(User::class);
        expect($found->getId()->getValue())->equals($user->getId()->getValue());
        expect($found->getUsername()->getValue())->equals($user->getUsername()->getValue());
        expect($found->access_token)->equals($user->access_token);
        expect($found->auth_key)->equals($user->auth_key);
    }

    /**
     * Test get user failed
     */
    public function testGetUserFailed()
    {
        $user = $this->module->createUser('user');

        $found = $this->module->getUser('admin');

        expect($found)->null();
    }

    /**
     * Test login no user
     */
    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
        ]);

        expect_not($this->module->login($model));
        expect_that(\Yii::$app->user->isGuest);
    }

    /**
     * Test login correct
     */
    public function testLoginCorrect()
    {
        $user = $this->module->createUser('user');

        $model = new LoginForm([
            'username' => $user->getUsername()->getValue(),
        ]);

        expect_that($this->module->login($model));
        expect_not(\Yii::$app->user->isGuest);
        expect($model->hasErrors())->false();
    }

}