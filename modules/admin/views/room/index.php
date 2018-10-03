<?php

use app\models\room\SearchModel;
use yii\data\DataProviderInterface;
use yii\web\View;
use yii\grid\GridView;
use yii\bootstrap\Html;

/** @var $this View  */
/** @var $searchModel SearchModel */
/** @var $dataProvider DataProviderInterface */

$this->title = \Yii::t('app', 'Admin');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= \Yii::t('app', 'Rooms list') ?>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                <?= Html::a(\Yii::t('app', 'Create'), ['room/create'], ['class' => 'btn btn-default']) ?>
                <?= Html::a(\Yii::t('app', 'Bookings list'), ['booking/index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            //'filterModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => \yii\grid\SerialColumn::class,
                ],
                [
                    'attribute' => 'name',
                    'value' => function (\app\models\room\Room $model) {
                        return Html::a($model->getName(), ['room/view', 'id' => $model->getId()->getValue()]);
                    },
                    'format' => 'raw'
                ],
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{view} {update}',
                ]
            ]
        ]) ?>
    </div>
</div>


