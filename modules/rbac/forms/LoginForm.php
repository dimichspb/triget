<?php

namespace app\modules\rbac\forms;

use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 *
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username','password',], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }
}
