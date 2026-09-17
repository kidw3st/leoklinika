<?php
namespace app\assets\base;

use app\components\base\AdminBundle;

class Select2Asset extends AdminBundle
{
    public $basePath = '@webroot/assets/src/select2';
    public $baseUrl = '@web/assets/src/select2';
    public $css = [
        'css/select2.min.css',
    ];
    public $js = [
        'js/select2.js',
        'select2_init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
