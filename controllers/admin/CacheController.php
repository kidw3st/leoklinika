<?php
namespace app\controllers\admin;

use app\controllers\base\AdminController;
use Yii;

class CacheController extends AdminController
{
    public function actionIndex()
    {
        Yii::$app->cache->flush();
        return $this->render('index');
    }
}