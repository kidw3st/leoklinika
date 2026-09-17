<?php
namespace app\assets;

use app\components\recaptcha\RecaptchaAsset;
use yii\web\AssetBundle;

class PjaxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        '/assets/base/pjax.min.js',
        '/assets/base/pjax_init.js',
    ];
    public $depends = [
    ];

    public static function register($view)
    {
        $res = parent::register($view);

        if (!empty($view->assetBundles[AppAsset::class])) {
            $view->assetBundles[static::class]->depends[] = AppAsset::class;
        }

        if (!empty($view->assetBundles[RecaptchaAsset::class])) {
            $view->assetBundles[PjaxAsset::class]->depends[] = RecaptchaAsset::class;
        }

        return $res;
    }
}
