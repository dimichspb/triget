<?php
namespace app\modules\rbac\acceptance;

use AcceptanceTester;
use app\modules\rbac\models\User;
use yii\helpers\Url;

class LoginCest
{
    protected $model;

    public function _before()
    {
        $this->model = new User();
        $this->model->username = 'user';
        $this->model->generateAccessToken();
        $this->model->generateAuthKey();
        $this->model->save();
    }

    public function _after()
    {
        User::deleteAll();
    }

    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/rbac/user/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see user info');
        $I->see('Logout');
    }
}
