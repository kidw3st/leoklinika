<?php
namespace app\components\recaptcha;

use Yii;
use yii\web\AssetBundle;

class RecaptchaAsset extends AssetBundle
{
    public $sourcePath = '@app/components/recaptcha/assets';

    public $css = [
    ];
    public $js = [
        'https://www.google.com/recaptcha/api.js?render=',
        'recaptcha.js',
    ];
    public $depends = [
        //'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js[0] .= Yii::$app->params['recaptcha']['site_key'];
    }

    public static function register($view)
    {
        if (!empty($view->assetBundles['app\assets\PjaxAsset'])) {
            $view->assetBundles['app\assets\PjaxAsset']->depends[] = static::class;
        }

        return parent::register($view);
    }
}
