<?php
namespace app\models\user\types;

use app\models\user\AccessToken;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class AccessTokenType extends GuidType
{
    const NAME = 'Type\User\AccessToken';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value AccessToken */
        return (string)$value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new AccessToken($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}