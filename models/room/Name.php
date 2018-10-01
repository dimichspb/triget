<?php
namespace app\models\room;

use app\entities\base\BaseString;
use Assert\Assertion;

class Name extends BaseString
{
    public function assert($value)
    {
        parent::assert($value);
        Assertion::maxLength($value, 64);
    }

}