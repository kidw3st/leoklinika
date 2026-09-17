<?php
use alente\kitum\Kitum;

$config['components']['db'] = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=project',
    'username' => 'project',
    'password' => 'project',
    'charset' => 'utf8',

    /*'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',*/
];

$config['components']['realmailer'] = [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => true,
];

$config['params']['admin']['debug'] = true;

$config['params']['recaptcha'] = [
    'site_key' => '',
    'secret_key' => '',
    'min_score' => 0.5,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'kitum';
    $config['modules']['kitum'] = [
        'class' => Kitum::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
        'generators' => [
            'andCrud' => [
                'class' => 'alente\kitum\generators\modelgenerator\Generator',
            ],
            'andController' => [
                'class' => 'alente\kitum\generators\controllergenerator\Generator',
            ],
            'andSettings' => [
                'class' => 'alente\kitum\generators\settingsgenerator\Generator',
            ],
            'andBlocks' => [
                'class' => 'alente\kitum\generators\blocksgenerator\Generator',
            ],
        ],
    ];
}

return $config;