<?php
namespace app\validators;

use app\models\booking\EndDate;
use app\models\booking\StartDate;
use app\models\room\Id;
use app\services\room\Service as RoomService;
use app\services\booking\Service as BookingService;
use yii\validators\DateValidator;
use yii\validators\Validator;

class DateRangeValidator extends Validator
{
    public $separator = ' - ';
    public $format = 'd-m-Y';
    public $minDate;
    public $targetAttribute;

    protected $roomService;

    protected $bookingService;

    public function __construct(RoomService $roomService, BookingService $bookingService, array $config = [])
    {
        $this->roomService = $roomService;
        $this->bookingService = $bookingService;

        parent::__construct($config);
    }

    public function validateAttribute($model, $attribute)
    {
        list($start, $end) = explode($this->separator, $model->$attribute, 2);
        $startDate = \DateTimeImmutable::createFromFormat($this->format, $start);
        $endDate = \DateTimeImmutable::createFromFormat($this->format, $end);

        $this->validateDates($model, $attribute, $startDate, $endDate);
        if ($this->targetAttribute) {
            $this->validateAvailability($model, $attribute, $this->targetAttribute, $startDate, $endDate);
        }
    }

    protected function validateDates($model, $attribute, $startDate, $endDate)
    {
        $today = $this->minDate? \DateTimeImmutable::createFromFormat($this->format, $this->minDate): new \DateTimeImmutable();

        if ($startDate < $today) {
            $this->addError($model, $attribute, 'Start date can not be in past');
        }

        if ($endDate < $startDate) {
            $this->addError($model, $attribute, 'End date can not be lass than start one');
        }
    }

    protected function validateAvailability($model, $attribute, $targetAttribute, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
    {
        $results = $this->bookingService->checkAvailability(new Id($model->$targetAttribute), new StartDate($startDate->format('d-m-Y')), new EndDate($endDate->format('d-m-Y')));

        foreach ($results as $result) {
            $this->addError($model, $attribute, 'This room is already booked for dates from: ' . $result->getStartDate()->getValue() . ' till: ' . $result->getEndDate()->getValue());
        }
    }
}