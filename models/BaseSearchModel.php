<?php
namespace app\models;

use yii\base\Model;

abstract class BaseSearchModel extends Model
{
    public function getAttributes($names = null, $except = [])
    {
        $attributes = array_filter(parent::getAttributes($names, $except), function ($value, $name) {
            return !is_null($value);
        }, ARRAY_FILTER_USE_BOTH);

        return $attributes;
    }
}