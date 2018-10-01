<?php

use app\models\room\Room;
use yii\web\View;
use yii\widgets\DetailView;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $this View */
/** @var $model Room */

$this->title = \Yii::t('app', $model->getName());

?>
<div class="col-xs-12 col-md-6">
    <div class="media">
        <div class="media-left">
            <?= Html::a(Html::img(Url::toRoute(['room/thumbnail', 'id' => $model->getId()->getValue()])), ['room/view', 'id' => $model->getId()->getValue()]) ?>
        </div>
        <div class="media-body">
            <h2 class="media-heading"><?= Html::encode($model->getName()->getValue()) ?></h2>
            <p><?= Html::encode($model->getDescription()->getShortValue()) ?></p>
            <div class="media-bottom">
                <?= Html::a(\Yii::t('app', 'Details'), ['room/view', 'id' => $model->getId()->getValue()], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</div>
