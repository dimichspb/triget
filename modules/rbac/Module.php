<?php

namespace app\modules\rbac;

use app\models\user\Username;
use app\models\user\User;
use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\forms\RegisterForm;
use app\services\user\Service;
use yii\base\BootstrapInterface;
use yii\web\Application;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var \yii\web\User|null
     */
    public $user;
    /**
     * @var Service
     */
    protected $service;

    public function __construct($id, \yii\base\Module $parent, Service $service, array $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $parent, $config);
    }


    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\rbac\commands';
            $this->user = null;
        }
        if ($app instanceof Application) {
            $this->controllerNamespace = 'app\modules\rbac\controllers';
            $this->user = $app->user;
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @param RegisterForm $form
     * @return bool whether the user is logged in successfully
     * @throws \yii\base\Exception
     */
    public function register(RegisterForm $form)
    {
        if (!$form->validate()) {
            return false;
        }

        $user = $this->getUserByUsername($form->username);

        if ($user) {
            $form->addError('username', 'User already exists');
            return false;
        }

        $user = $this->createUser($form->username, $form->password);

        return $this->user? $this->user->login($user, 3600*24*30): true;
    }

    /**
     * Creates User
     *
     * @param $username
     * @param $password
     * @return User
     * @throws \yii\base\Exception
     */
    public function createUser($username, $password)
    {
        $user = new User($this->service->nextId());
        $user->setUsername(new Username($username));
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->setPassword($password);

        $this->service->add($user);

        return $user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @param LoginForm $form
     * @return bool whether the user is logged in successfully
     */
    public function login(LoginForm $form)
    {
        if (!$form->validate()) {
            return false;
        }

        $user = $this->getUserByUsername($form->username);

        if (!$user) {
            $form->addError('username', 'User not found');
            return false;
        }

        if (!$user->validatePassword($form->password)) {
            $form->addError('password', 'Incorrect password');
            return false;
        }

        return $this->user? $this->user->login($user, $form->rememberMe ? 3600*24*30 : 0): true;
    }

    /**
     * Finds user by [[username]]
     *
     * @param $username
     * @return User|null
     */
    protected function getUserByUsername($username)
    {
        return $this->service->getByUsername(new Username($username));
    }
}
