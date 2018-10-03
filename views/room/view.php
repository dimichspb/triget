<?php

use app\forms\room\BookingForm;
use app\models\room\Room;
use yii\web\View;
use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var $this View */
/** @var $model Room */
/** @var $form BookingForm */

$this->title = $model->getName()->getValue();

$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
    <<<JS
$(".btn-book-room").on("click", function(event) {
    var id = $(this).data('id');
    $("#bookingform-id").val(id);
});
JS

)
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= \yii\bootstrap\Html::encode($model->getName()) ?>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                <?= Html::a(\Yii::t('app', 'Booking'), ['room/book', 'id' => $model->getId()->getValue()], ['class' => 'btn btn-default btn-book-room', 'data' => ['id' => $model->getId()->getValue(), 'toggle' => 'modal', 'target' => '#booking-modal']]) ?>
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

<?= $this->render('_booking', [
    'form' => $form,
]); ?>
