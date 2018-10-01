<?php

namespace app\modules\admin\forms;

use app\forms\room\UploadForm;

/**
 * CreateForm is the model behind the create form.
 *
 */
class CreateForm extends UploadForm
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge($rules, [
            [['name', 'description'], 'string'],
            [['name', 'description'], 'required'],
        ]);
    }
}
