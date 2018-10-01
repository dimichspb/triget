<?php

use app\modules\admin\forms\UpdateForm;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\bootstrap\Html;

/** @var $this View */
/** @var $form UpdateForm */
/** @var $model \app\models\room\Room */

$this->title = \Yii::t('app', 'Update ' . $model->getName());

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['room/index']];
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['room/update', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="admin-room-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to update:</p>

    <?php $activeForm = ActiveForm::begin([
        'id' => 'update-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $activeForm->field($form, 'name')->textInput(['autofocus' => true]) ?>

        <?= $activeForm->field($form, 'description')->textarea(['rows' => 5]) ?>

        <?= $activeForm->field($form, 'image')->fileInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>


