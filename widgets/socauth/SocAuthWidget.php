<?php

namespace app\widgets\socauth;

use app\assets\base\SocAuthAsset;
use Yii;

class SocAuthWidget extends \yii\base\Widget {
    public $template = 'index';
    public $redirectUri = false;
    public $backUrl = false;

    public function init()
    {
        if ($this->backUrl === false) $this->backUrl = Yii::$app->request->url;
        if ($this->redirectUri === false) $this->redirectUri = Yii::$app->urlManager->createAbsoluteUrl(['/admin/user/soclogin', 'backurl' => $this->backUrl]);

        SocAuthAsset::register(Yii::$app->view);

        parent::init();
    }

    public function run()
    {
        return $this->render($this->template, [
            'links' => [
                'vk' => 'https://auth.alente.ru/vk?redirect_uri='.urlencode($this->redirectUri),
                'fb' => 'https://auth.alente.ru/fb?redirect_uri='.urlencode($this->redirectUri),
                'google' => 'https://auth.alente.ru/google?redirect_uri='.urlencode($this->redirectUri),
            ],
        ]);
    }
}