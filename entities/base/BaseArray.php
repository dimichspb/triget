<?php
namespace app\entities\base;

use Assert\Assertion;

abstract class BaseArray extends BaseEntity implements \Iterator
{
    public function assert($value)
    {
        Assertion::isArray($value);
    }

    public function rewind()
    {
        reset($this->value);
    }

    public function current()
    {
        $var = current($this->value);
        return $var;
    }

    public function key()
    {
        $var = key($this->value);
        return $var;
    }

    public function next()
    {
        $var = next($this->value);
        return $var;
    }

    public function valid()
    {
        $key = key($this->value);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
}