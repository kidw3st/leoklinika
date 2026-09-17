<?php
$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\base\Route'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'Osdsadkajskldasmd21kll1nlk35asd12dsp33ddqooxc',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //'authManager' => [
        //    'class' => 'yii\rbac\DbManager',
        //],
        'user' => [
            'identityClass' => \app\models\SystemUser::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
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
                '/<module:elfinder>/<controller:[-\w]+>/<action:[-\w]+>'                                         => '<module>/<controller>/<action>',
                '/<module:elfinder>/<controller:[-\w]+>'                                                         => '<module>/<controller>',

                '/admin/ajax/public'                                                                             => 'admin/ajax/public',
                '/admin/ajax'                                                                                    => 'admin/ajax/index',
                '/admin/gii_start'                                                                               => 'admin/dashboard/gii',
                '/admin/gii'                                                                                     => 'admin/gii/index',
                '/admin/login'                                                                                   => 'admin/user/login',
                '/admin/logout'                                                                                  => 'admin/user/logout',
                '/admin/soclogin'                                                                                => 'admin/user/soclogin',
                [
                    'pattern' => 'admin/model/<handle:[-\_\/\w\=]+>',
                    'route' => 'admin/model/index',
                    'encodeParams' => false,
                ],
                '/admin/<controller:[-\_\w]+>/a_<action:[-\_\/\w]+>'                                             => 'admin/<controller>/<action>',
                '/admin'                                                                                         => 'admin/dashboard/index',
                '/sitemap<page:\d+>.xml'                                                                         => 'system/sitemap/index',
                '/sitemap.xml'                                                                                   => 'system/sitemap/index',

                '/api/<action:[-\_\w]+>'                                                                         => 'api/<action>',
            ],
        ],
        'assetManager' => [
            /*'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        '/assets/dl/jquery-1.11.0.min.js',  // use custom jquery
                    ]
                ],
            ],*/
            'basePath' => '@webroot/yii-assets',
            'baseUrl' => '/yii-assets',
        ],
    ],
    'on beforeRequest' => function () {
        $app = Yii::$app;
        $pathInfo = $app->request->pathInfo;

        if (!empty($pathInfo) && substr($pathInfo, -1) === '/') {
            $app->response->redirect('/' . rtrim($pathInfo, '/'), 301);
            $app->end();
        }
        if (preg_match('/https?\:\/\/www\./', $app->request->absoluteUrl)) {
            $app->response->redirect(preg_replace('/(https?\:\/\/)www\./', '$1', $app->request->absoluteUrl), 301);
            $app->end();
        }
        if (preg_match('/index\.php$/', $app->request->absoluteUrl)) {
            $app->response->redirect(preg_replace('/index\.php$/', '', $app->request->absoluteUrl), 301);
            $app->end();
        }
    },
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl'=>'@web',
                    'basePath'=>'@webroot',
                    'path' => 'up',
                    'name' => 'Global'
                ],
            ],
        ],
    ],
    'params' => [
        'recaptcha' => [
            'enable' => false,
            'site_key' => '',
            'secret_key' => '',
            'min_score' => 0.5,
        ],
    ],
];

if (file_exists(__DIR__ . '/common.php')) $config = require __DIR__ . '/common.php';
if (file_exists(__DIR__ . '/common-local.php')) $config = require __DIR__ . '/common-local.php';
if (file_exists(__DIR__ . '/web-local.php')) $config = require __DIR__ . '/web-local.php';

return $config;
