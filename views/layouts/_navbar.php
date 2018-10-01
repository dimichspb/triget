<?php

use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$items = [];
if (\Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Register', 'url' => ['/rbac/user/register']];
    $items[] = ['label' => 'Login', 'url' => ['/rbac/user/login']];
} else {
    $items[] = ['label' => 'Admin', 'url' => ['/admin/room/index']];
    $items[] = (
        '<li>'
        . Html::beginForm(['/rbac/user/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->getUsername() . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>'
    );
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
]);
NavBar::end();