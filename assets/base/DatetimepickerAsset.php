<?php
namespace app\assets\base;

use app\components\base\AdminBundle;

class DatetimepickerAsset extends AdminBundle
{
    public $basePath = '@webroot/assets/src/datetimepicker';
    public $baseUrl = '@web/assets/src/datetimepicker';
    public $css = [
        'css/bootstrap-datetimepicker.min.css',
    ];
    public $js = [
        'moment/moment.min.js',
        'js/bootstrap-datetimepicker.min.js',
        'datetimepicker_init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}