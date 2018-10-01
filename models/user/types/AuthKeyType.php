<?php
namespace app\models\user\types;

use app\models\user\AuthKey;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class AuthKeyType extends GuidType
{
    const NAME = 'Type\User\AuthKey';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value AuthKey */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new AuthKey($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}