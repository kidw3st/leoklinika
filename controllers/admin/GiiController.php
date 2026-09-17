<?php
namespace app\controllers\admin;

use Yii;
use yii\web\Controller;

class GiiController extends Controller
{
    public function actionIndex($parent = false)
    {
        return $this->redirect('/gii');
    }
}