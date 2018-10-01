<?php
namespace app\models\room\types;

use app\models\room\Image;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class ImageType extends GuidType
{
    const NAME = 'Type\Room\Image';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Image */
        return $value? (string)$value->getValue(): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value? new Image($value): null;
    }

    public function getName()
    {
        return self::NAME;
    }
}