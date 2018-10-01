<?php
namespace app\models\user\types;

use app\models\user\PasswordHash;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class PasswordHashType extends GuidType
{
    const NAME = 'Type\User\PasswordHash';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value PasswordHash */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new PasswordHash($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}