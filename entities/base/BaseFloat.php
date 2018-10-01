<?php
namespace app\entities\base;

use Assert\Assertion;

abstract class BaseFloat extends BaseEntity
{
    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        Assertion::numeric($value);
    }
}