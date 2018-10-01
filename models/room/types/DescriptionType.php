<?php
namespace app\models\room\types;

use app\models\room\Description;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class DescriptionType extends GuidType
{
    const NAME = 'Type\Room\Description';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Description */
        return $value? (string)$value->getValue(): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value? new Description($value): null;
    }

    public function getName()
    {
        return self::NAME;
    }
}