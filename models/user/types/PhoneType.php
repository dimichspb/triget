<?php
namespace app\models\user\types;

use app\models\user\Phone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class PhoneType extends GuidType
{
    const NAME = 'Type\User\Phone';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Phone */
        return $value? (string)$value->getValue(): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value? new Phone($value): null;
    }

    public function getName()
    {
        return self::NAME;
    }
}