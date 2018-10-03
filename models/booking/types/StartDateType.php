<?php
namespace app\models\booking\types;

use app\models\booking\StartDate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class StartDateType extends GuidType
{
    const NAME = 'Type\Booking\StartDate';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var $value StartDate */
        return $value? (string)date('Y-m-d', strtotime($value->getValue())): null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value? new StartDate(date('d-m-Y', strtotime($value))): null;
    }

    public function getName()
    {
        return self::NAME;
    }
}