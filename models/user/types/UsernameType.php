<?php
namespace app\models\user\types;

use app\models\user\Username;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UsernameType extends GuidType
{
    const NAME = 'Type\User\Username';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Username */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Username($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}