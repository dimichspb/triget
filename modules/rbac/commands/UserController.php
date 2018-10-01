<?php

namespace app\modules\rbac\commands;

use app\modules\rbac\forms\CreateForm;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class UserController
 * @package app\modules\commands
 *
 * @property \app\modules\rbac\Module $module
 */
class UserController extends Controller
{
    public $defaultAction = 'register';

    /**
     * This command creates admin user.
     * @param $username
     * @param $password
     * @return int Exit code
     * @throws \yii\base\Exception
     */
    public function actionRegister($username, $password)
    {
        $form = new CreateForm();
        $form->username = $username;
        $form->password = $password;

        $this->module->register($form);

        if ($form->hasErrors()) {
            foreach ($form->errors as $attribute => $errors) {
                $this->stderr($attribute . ': ' . implode("\n", $errors));
            }
        }
        return ExitCode::OK;
    }
}
