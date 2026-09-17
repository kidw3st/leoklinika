<?php

namespace app\components\base;

use app\helpers\base\SystemHelper;
use app\models\Language;
use Yii;
use yii\web\UrlRule;

class LocaleUrlRule extends UrlRule {
    private $is_admin_page = null;

    public function createUrl($manager, $route, $params)
    {
        if ($this->is_admin_page === null) {
            $this->is_admin_page = ((strpos(Yii::$app->request->url, '/admin') !== false)?true:false);
        }
        $res = parent::createUrl($manager, $route, $params);
        if ($this->is_admin_page) return $res;

        $language = SystemHelper::Language();

        if ($res !== false) {
            $resItems = explode('?', $res);
            if ($resItems[0]) {
                $resItems[0] = $language->handle_real . '/' . $resItems[0];
            } else {
                $resItems[0] = $language->handle_real;
            }
            $res = implode('?', $resItems);
        }

        return $res;
    }
}