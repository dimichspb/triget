<?php
namespace app\entities\base;

abstract class BaseDateTime extends BaseEntity
{
    /**
     * @param $value
     */
    public function assert($value)
    {

    }

    public function __toString()
    {
        return (string)$this->value;
    }
}