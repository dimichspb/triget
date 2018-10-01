<?php
namespace app\entities\base;

use Assert\Assertion;

abstract class BaseFilename extends BaseEntity
{
    public function assert($value)
    {
        Assertion::regex($value, '/^[\w,\s-]+\.[A-Za-z]{3}$/');
    }

}