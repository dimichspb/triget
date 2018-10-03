<?php
namespace app\modules\rbac\tests\unit;

use app\models\user\Id;
use app\models\user\User;
use app\models\user\Username;
use app\modules\rbac\forms\RegisterForm;
use Codeception\Test\Unit;

class RegisterFormTest extends Unit
{
    /**
     * Test validate username success
     */
    public function testValidateUsernameSuccess()
    {
        $model = new RegisterForm();
        $model->username = 'user1';

        expect($model->validate())->true();
        expect($model->hasErrors('username'))->false();
    }

    /**
     * Test validate username null failed
     */
    public function testValidateUsernameNullFailed()
    {
        $model = new RegisterForm();
        $model->username = null;

        expect($model->validate())->false();
        expect($model->hasErrors('username'))->true();
    }

    /**
     * Test validate username exists failed
     */
    public function testValidateUsernameExistsFailed()
    {
        $user = new User(new Id(1));
        $user->setUsername(new Username('user1'));
        $user->generateAccessToken();
        $user->generateAuthKey();


        $model = new RegisterForm();
        $model->username = $user->getUsername()->getValue();

        expect($model->validate())->false();
        expect($model->hasErrors('username'))->true();
    }
}