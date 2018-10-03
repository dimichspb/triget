<?php
namespace app\models\booking\types;

use app\models\booking\Confirmed;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class ConfirmedType extends GuidType
{
    const NAME = 'Type\Booking\Confirmed';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value Confirmed */
        return $value? (int)$value->getValue(): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Confirmed((bool)$value);
    }

    public function getName()
    {
        return self::NAME;
    }
}