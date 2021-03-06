<?php
namespace app\entities\base;

use Assert\Assertion;

class BaseHash extends BaseString
{
    public function assert($value)
    {
        Assertion::maxLength($value, 36);

        parent::assert($value);
    }
}