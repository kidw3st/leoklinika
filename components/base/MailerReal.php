<?php

namespace app\components\base;

use app\models\SystemSettings;
use Yii;

class MailerReal {
    private static $_mailer = false;

    public static function mailer()
    {
        if (static::$_mailer === false) {
            if (!empty(Yii::$app->components['realmailer']) && empty(Yii::$app->components['realmailer']['useFileTransport']) && empty(Yii::$app->components['realmailer']['transport'])) {
                Yii::$app->setComponents([
                    'realmailer' => [
                        'class' => 'yii\swiftmailer\Mailer',
                        'useFileTransport' => false,
                        'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            'host' => SystemSettings::getParam('mail', 'smtp_host', 'smtp.gmail.com'),
                            'username' => SystemSettings::getParam('mail', 'smtp_username', 'testnotification99@gmail.com'),
                            'password' => SystemSettings::getParam('mail', 'smtp_password', 'testing99'),
                            'port' => SystemSettings::getParam('mail', 'smtp_port', '465'),
                            'encryption' => SystemSettings::getParam('mail', 'smtp_encrypt', 'ssl'),
                        ],
                    ],
                ]);
            }
            static::$_mailer = Yii::$app->realmailer;
        }

        return static::$_mailer = Yii::$app->realmailer;
    }
}