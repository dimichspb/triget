<?php
namespace app\models\booking\types;

use app\models\booking\EndDate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class EndDateType extends GuidType
{
    const NAME = 'Type\Booking\EndDate';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value EndDate */
        return $value? (string)date('Y-m-d', strtotime($value->getValue())): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value? new EndDate(date('d-m-Y', strtotime($value))): null;
    }

    public function getName()
    {
        return self::NAME;
    }
}