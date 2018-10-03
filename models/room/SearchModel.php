<?php

namespace app\models\room;

use app\models\BaseSearchModel;

/**
 * Search represents the model behind the search form of `app\models\room\Room`.
 */
class SearchModel extends BaseSearchModel
{
    public $id;
    public $name;
    public $page;
    public $limit;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
            [['page', 'limit'], 'integer'],
        ];
    }
}
