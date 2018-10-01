<?php

namespace app\modules\rbac\forms;

use yii\base\Model;

/**
 * RegisterForm is the model behind the register form.
 *
 */
class RegisterForm extends Model
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
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username',], 'required'],
            [['password',], 'required'],
        ];
    }
}
