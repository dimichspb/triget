<?php
namespace app\modules\rbac\tests\unit;

use app\modules\rbac\forms\CreateForm;
use app\modules\rbac\models\User;
use Codeception\Test\Unit;

class RegisterFormTest extends Unit
{
    /**
     * Test validate username success
     */
    public function testValidateUsernameSuccess()
    {
        $model = new CreateForm();
        $model->username = 'user1';

        expect($model->validate())->true();
        expect($model->hasErrors('username'))->false();
    }

    /**
     * Test validate username null failed
     */
    public function testValidateUsernameNullFailed()
    {
        $model = new CreateForm();
        $model->username = null;

        expect($model->validate())->false();
        expect($model->hasErrors('username'))->true();
    }

    /**
     * Test validate username exists failed
     */
    public function testValidateUsernameExistsFailed()
    {
        $user = new User();
        $user->username = 'user1';
        $user->generateAccessToken();
        $user->generateAuthKey();
        $user->save();

        $model = new CreateForm();
        $model->username = $user->username;

        expect($model->validate())->false();
        expect($model->hasErrors('username'))->true();
    }
}