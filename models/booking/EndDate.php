<?php
namespace app\models\booking;

use app\entities\base\BaseDateTime;

class EndDate extends BaseDateTime
{
    public function getDbValue()
    {
        return date('Y-m-d', strtotime($this->getValue()));
    }
}