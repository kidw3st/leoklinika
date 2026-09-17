<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets/front/static/bvi/css/bvi.min.css',
        'assets/front/css/main.css',
    ];
    public $js = [
        'assets/front/js/vendor.js',
        'assets/front/js/main.js',
        'assets/base/second.js',
        'assets/front/static/bvi/js/bvi.min.js',
        'assets/front/static/bvi/js/bvi.init.js',
    ];
    public $depends = [
    ];
}
