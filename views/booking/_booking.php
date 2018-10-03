<?php

use yii\web\View;
use yii\bootstrap\Modal;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Html;

/** @var $this View */
/** @var $form \app\forms\room\BookingForm */

?>
<?php Modal::begin([
    'id' => 'booking-modal',
    'header' => '<h2>Booking form</h2>',
    'size' => Modal::SIZE_LARGE,
]);
?>
<?php $activeForm = ActiveForm::begin([
    'id' => 'booking-form',
    'action' => ['booking/create'],
    'enableAjaxValidation' => true,
    'validationUrl' => ['booking/validate'],
]) ?>

<div class="row">
    <div class="col-xs-12 col-md-4">

        <?= $activeForm->field($form, 'name')->textInput() ?>

        <?= $activeForm->field($form, 'phone')->textInput() ?>

        <?= $activeForm->field($form, 'id')->hiddenInput()->label(false)->error(false) ?>

    </div>
    <div class="col-xs-12 col-md-8">
        <?= $activeForm->field($form, 'range', [
            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
            'options'=>['class'=>'drp-container form-group']
        ])->widget(DateRangePicker::class, [
            'useWithAddon' => true,
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => ['format' => 'd-m-Y'],
            ],
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-right">
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Book now', ['class' => 'btn btn-primary', 'name' => 'booking-button']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>