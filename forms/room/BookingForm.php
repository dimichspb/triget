<?php
namespace app\forms\room;

use app\validators\DateRangeValidator;
use yii\base\Model;

class BookingForm extends Model
{
    public $id;
    public $name;
    public $phone;
    public $range;

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'name', 'phone', 'range'], 'required'],
            [
                ['name'],
                'match',
                'pattern' => '/^[a-zA-Z\s\-\x{0400}-\x{04FF}]{2,}$/u',
                'message' => \Yii::t('app', 'Only english or russian letters, space and minus are supported'),
            ],
            [
                ['phone'],
                'match',
                'pattern' => '/^\+[0-9]{11}$/',
                'message' => \Yii::t('app', 'Please use international format +01234567890 (plus sign followed by eleven numbers)'),
            ],
            [
                ['range'],
                'match',
                'pattern' => '/^([0-9]{2})-([0-9]{2})-([0-9]{4}) - ([0-9]{2})-([0-9]{2})-([0-9]{4})$/',
                'message' => \Yii::t('app', 'Please use format DD-MM-YYYY - DD-MM-YYYY'),
            ],
            ['range', DateRangeValidator::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * Get start date from range
     * @return mixed
     */
    public function getStartDate()
    {
        list($start, $end) = explode(' - ', $this->range, 2);
        return $start;
    }

    /**
     * Get end date from range
     * @return mixed
     */
    public function getEndDate()
    {
        list($start, $end) = explode(' - ', $this->range, 2);
        return $end;
    }
}