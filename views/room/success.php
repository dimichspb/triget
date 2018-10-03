<?php

use app\forms\room\BookingForm;
use app\models\room\Room;
use app\models\user\User;
use yii\web\View;
use yii\helpers\Html;


/** @var $this View */
/** @var $form BookingForm */

$this->title = \Yii::t('app', 'Booking completed');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <h2>Congratulations!</h2>

    <p>You have successfully completed the booking of the room. We will email you shortly after confirmation.</p>

    <?= Html::a(\Yii::t('app', 'Back'), ['room/index'], ['class' => 'btn btn-default']) ?>
</div>

