<?php
namespace app\assets\base;

use app\components\base\AdminBundle;

class Js_treeAsset extends AdminBundle
{
    public $basePath = '@webroot/assets/src/jstree';
    public $baseUrl = '@web/assets/src/jstree';
    public $css = [
        'themes/default/style.min.css',
    ];
    public $js = [
        'jstree.min.js',
        'jstree_init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
