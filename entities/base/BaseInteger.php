<?php
namespace app\entities\base;

use Assert\Assertion;

abstract class BaseInteger extends BaseEntity
{
    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        Assertion::integer($value);
    }
}