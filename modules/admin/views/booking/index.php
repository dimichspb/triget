<?php

use app\models\booking\SearchModel;
use yii\data\DataProviderInterface;
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\booking\Booking;

/** @var $this View */
/** @var $searchModel SearchModel */
/** @var $dataProvider DataProviderInterface */

$this->title = \Yii::t('app', 'Booking list');

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['room/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= \Yii::t('app', 'Bookings list') ?>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                <?= Html::a(\Yii::t('app', 'Rooms list'), ['room/index'], ['class' => 'btn btn-default']) ?>
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
                    'attribute' => 'room',
                    'value' => function (Booking $model) {
                        return Html::a($model->getRoom()->getName(), ['room/view', 'id' => $model->getRoom()->getId()->getValue()]);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'user',
                    'value' => function (Booking $model) {
                        return $model->getUser()->getName();
                    }
                ],
                [
                    'attribute' => 'startDate',
                    'value' => function (Booking $model) {
                        return $model->getStartDate()->getValue();
                    }
                ],
                [
                    'attribute' => 'endDate',
                    'value' => function (Booking $model) {
                        return $model->getEndDate()->getValue();
                    }
                ],
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{confirm}',
                    'buttons' => [
                        'confirm' => function ($url, Booking $model, $key) {
                            return
                                $model->getConfirmed()->getValue()?
                                    Html::a('<span class="glyphicon glyphicon-remove"></span>', ['booking/decline', 'id' => $model->getId()->getValue()], ['title' => \Yii::t('app', 'Decline'), 'data' => ['method' => 'post']]):
                                    Html::a('<span class="glyphicon glyphicon-ok"></span>', ['booking/confirm', 'id' => $model->getId()->getValue()], ['title' => \Yii::t('app', 'Confirm'), 'data' => ['method' => 'post']]);
                        },
                    ]
                ]
            ]
        ]) ?>
    </div>
</div>
