<?php
namespace app\entities\base;

use Assert\Assertion;

class BaseId extends BaseString
{
    public function assert($value)
    {
        Assertion::maxLength($value, 36);

        parent::assert($value);
    }
}