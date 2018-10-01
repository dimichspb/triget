<?php
namespace app\models\user\types;

use app\models\user\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class NameType extends GuidType
{
    const NAME = 'Type\User\Name';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Name */
        return $value? (string)$value->getValue(): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value? new Name($value): null;
    }

    public function getName()
    {
        return self::NAME;
    }
}