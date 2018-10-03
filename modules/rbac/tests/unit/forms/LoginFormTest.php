<?php

namespace app\modules\rbac\tests\unit;

use app\modules\rbac\forms\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * Test validate username success
     */
    public function testValidateUsernameSuccess()
    {
        $model = new LoginForm();
        $model->username = 'user1';

        expect($model->validate())->true();
        expect($model->hasErrors('username'))->false();
    }

    /**
     * Test validate username null failed
     */
    public function testValidateUsernameNullFailed()
    {
        $model = new LoginForm();
        $model->username = null;

        expect($model->validate())->false();
        expect($model->hasErrors('username'))->true();
    }
}
