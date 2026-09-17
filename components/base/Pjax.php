<?php

namespace app\components\base;

use Yii;
use yii\widgets\PjaxAsset;

class Pjax extends \yii\widgets\Pjax {
    public $reloadBlocks = [];
    public $reloadSync = false;
    public $enablePushState = false;
    public $timeout = 10000;

    public function init()
    {
        if (!is_array($this->reloadBlocks)) $this->reloadBlocks = [$this->reloadBlocks];

        parent::init();
    }

    public function run()
    {
        if (count($this->reloadBlocks) > 0 && Yii::$app->request->isAjax) {
            echo '<script type="text/javascript">';
            foreach ($this->reloadBlocks as $reloadBlock) {
                echo '$.pjax.reload({container: "'.$reloadBlock.'", async: '.($this->reloadSync?'true':'false').'});';
            }
            echo '</script>';
        }

        return parent::run();
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        PjaxAsset::register($view);
    }
}