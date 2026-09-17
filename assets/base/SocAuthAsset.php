<?php
namespace app\assets\base;

use app\components\base\AdminBundle;

class SocAuthAsset extends AdminBundle
{
    public $basePath = '@webroot/assets/src/soc_auth';
    public $baseUrl = '@web/assets/src/soc_auth';
    public $css = [
        'css/soc_auth.css',
    ];
    public $js = [
        'js/soc_auth.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
