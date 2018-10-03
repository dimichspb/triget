<?php
namespace app\forms\room;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $image;

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
        ];
    }
}