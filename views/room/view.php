<?php

use app\models\room\Room;
use yii\web\View;
use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var $this View */
/** @var $model Room */

$this->title = $model->getName()->getValue();

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= \yii\bootstrap\Html::encode($model->getName()) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
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
