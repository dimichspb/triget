<?php
namespace app\models\room;

use app\entities\base\BaseString;
use Assert\Assertion;
use yii\helpers\StringHelper;

class Description extends BaseString
{
    public function assert($value)
    {
        parent::assert($value);
        Assertion::maxLength($value, 1024);
    }

    public function getShortValue()
    {
        $short = StringHelper::truncateWords($this->value, 30);

        return strlen($this->value) > 30? $short . '...': $short;
    }
}