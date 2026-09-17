<?php
namespace app\assets\base;

use app\components\base\AdminBundle;

class DatepickerAsset extends AdminBundle
{
    public $basePath = '@webroot/assets/src/datepicker';
    public $baseUrl = '@web/assets/src/datepicker';
    public $css = [
        'css/bootstrap-datepicker.css',
    ];
    public $js = [
        'js/bootstrap-datepicker.min.js',
        'datepicker_init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
