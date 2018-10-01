<?php
namespace app\models\room;

use app\entities\base\BaseFilename;
use Assert\Assertion;

class Image extends BaseFilename
{
    public function assert($value)
    {
        parent::assert($value);
        Assertion::inArray(pathinfo($value, PATHINFO_EXTENSION), static::allowedExtensions());
        Assertion::maxLength($value, 64);
    }

    public static function allowedExtensions()
    {
        return [
            'jpg',
            'gif',
            'png',
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}