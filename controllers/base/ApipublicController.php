<?php

namespace app\controllers\base;

use app\helpers\base\UserHelper;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class ApipublicController extends Controller
{
    public function apires($res, $refererAction = false, $backurl = false, $forceAjax = false, $json = true) {
        UserHelper::update();
        if (Yii::$app->request->isAjax || $forceAjax) {
            if ($refererAction) {
                $request = new Request(['url' => parse_url(Yii::$app->request->referrer, PHP_URL_PATH)]);
                $url = Yii::$app->urlManager->parseRequest($request);

                return Yii::$app->runAction($url[0], $url[1]);
            } else {
                if ($json) Yii::$app->response->format = Response::FORMAT_JSON;

                return $res;
            }
        } else {
            return $this->redirect($backurl?:Yii::$app->request->referrer);
        }
    }
}