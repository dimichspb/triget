<?php

use app\models\room\SearchModel;
use yii\data\DataProviderInterface;
use yii\web\View;

/** @var $this View */
/** @var $searchModel SearchModel */
/** @var $dataProvider DataProviderInterface */
/** @var $form \app\forms\room\BookingForm */

$this->title = \Yii::t('app', 'Rooms');

?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_room', [
                        'model' => $model,
                    ]);
                },
                'layout'=> "{items}\n{pager}"
            ]); ?>
        </div>
    </div>
</div>

<?= $this->render('_booking', [
    'form' => $form,
]); ?>
