<?php

use app\models\booking\SearchModel;
use app\models\room\Room;
use app\models\booking\Booking;
use yii\data\DataProviderInterface;
use yii\web\View;
use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var $this View */
/** @var $model Room */
/** @var $searchModel SearchModel */
/** @var $dataProvider DataProviderInterface */

$this->title = $model->getName();

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Admin'), 'url' => ['room/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= \yii\bootstrap\Html::encode($model->getName()) ?>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                <?= Html::a(\Yii::t('app', 'Update'), ['room/update', 'id' => $model->getId()], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'value' => $model->getId(),
                        ],
                        [
                            'attribute' => 'name',
                            'value' => $model->getName(),
                        ],
                        [
                            'attribute' => 'description',
                            'value' => $model->getDescription(),
                        ],
                        [
                            'attribute' => 'image',
                            'value' => Html::img(Url::to(['/room/image', 'id' => $model->getId()->getValue()])),
                            'format' => 'raw'
                        ],
                    ]
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?= GridView::widget([
                    //'filterModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'user',
                            'label' => \Yii::t('app', 'Name'),
                            'value' => function (Booking $model) {
                                return $model->getUser()->getName();
                            },
                        ],
                        [
                            'attribute' => 'user',
                            'label' => \Yii::t('app', 'Phone'),
                            'value' => function (Booking $model) {
                                return $model->getUser()->getPhone();
                            },
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
    </div>
</div>
