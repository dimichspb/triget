<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'rooms-web',
    'name' => 'Rooms',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \app\bootstrap\Bootstrap::class,
        'rbac',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'vlpG59bZRcAOfykMee2YFpVny9lvziX8',
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => app\models\user\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['rbac/user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'room/index',
                'rooms' => 'room/index',
                'register' => 'rbac/user/register',
                'login' => 'rbac/user/login',
                'logout' => 'rbac/user/logout',
                'bookings/create' => 'booking/create',
                'bookings/validate' => 'booking/validate',
                'rooms/image/<id:\w+>' => 'room/image',
                'rooms/thumbnail/<id:\w+>' => 'room/thumbnail',
                'rooms/<id:\w+>' => 'room/view',
                'admin' => 'admin/room/index',
                'admin/rooms/create' => 'admin/room/create',
                'admin/rooms/<id:\w+>' => 'admin/room/view',
                'admin/rooms/<id:\w+>/update' => 'admin/room/update',
                'admin/bookings' => 'admin/booking/index',
                'admin/booking/confirm/<id:\w+>' => 'admin/booking/confirm',
                'admin/booking/decline/<id:\w+>' => 'admin/booking/decline',
            ],
        ],
    ],
    'modules' => [
        'rbac' => [
            'class' => app\modules\rbac\Module::class,
        ],
        'admin' => [
            'class' => \app\modules\admin\Module::class,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
