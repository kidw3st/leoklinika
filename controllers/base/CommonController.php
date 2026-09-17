<?php

namespace app\controllers\base;

use app\helpers\base\UserHelper;
use Yii;
use yii\web\Controller;

class CommonController extends Controller
{
    public function init()
    {
        if (!Yii::$app->request->isConsoleRequest) UserHelper::init();

        parent::init();
    }

    public function afterAction($action, $result)
    {
        UserHelper::update();
        return parent::afterAction($action, $result);
    }

    public function render($view, $params = [])
    {
        UserHelper::update();
        return parent::render($view, $params);
    }

    public function renderAjax($view, $params = [])
    {
        UserHelper::update();
        return parent::renderAjax($view, $params);
    }

    public function renderFile($file, $params = [])
    {
        UserHelper::update();
        return parent::renderFile($file, $params);
    }

    public function renderPartial($view, $params = [])
    {
        UserHelper::update();
        return parent::renderPartial($view, $params);
    }

    public function renderContent($content)
    {
        UserHelper::update();
        return parent::renderContent($content);
    }
}