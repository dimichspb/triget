<?php
namespace app\entities\base;

abstract class BaseEntity
{
    protected $value;

    /**
     * BaseEntity constructor.
     * @param null $value
     */
    public function __construct($value = null)
    {
        $this->assert($value);
        $this->value = $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    abstract public function assert($value);

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }
}