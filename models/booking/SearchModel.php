<?php

namespace app\models\booking;

use app\models\BaseSearchModel;

/**
 * Search represents the model behind the search form of `app\models\room\Room`.
 */
class SearchModel extends BaseSearchModel
{
    public $id;
    public $room;
    public $name;
    public $phone;
    public $startDate;
    public $endDate;
    public $page;
    public $limit;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'room', 'name', 'phone', 'startDate', 'endDate'], 'safe'],
            [['startDate', 'endDate'], 'date', 'format' => 'd-m-Y'],
            [['page', 'limit'], 'integer'],
        ];
    }
}
