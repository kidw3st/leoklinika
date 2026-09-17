<?php

use app\models\SystemSettings;

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@webroot' => '@app/web',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        /*'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \app\models\SystemUser::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
            'autoRenewCookie' => false,
        ],*/
    ],
];

if (file_exists(__DIR__ . '/common.php')) $config = require __DIR__ . '/common.php';
if (file_exists(__DIR__ . '/common-local.php')) $config = require __DIR__ . '/common-local.php';
if (file_exists(__DIR__ . '/console-local.php')) $config = require __DIR__ . '/console-local.php';

return $config;
