<?php
namespace app\models\user;

use app\entities\base\BaseHash;
use Assert\Assertion;

class PasswordHash extends BaseHash
{
    public function assert($value)
    {
        Assertion::maxLength($value, 255);
    }

}