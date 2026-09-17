<?php 
namespace app\controllers;

use app\controllers\base\ApipublicController;
use app\helpers\base\UserHelper;

class ApiController extends ApipublicController
{
    public function actionChange_city($id) {
        UserHelper::init();
        UserHelper::setParam('city', $id);

        return $this->apires(true);
    }
}