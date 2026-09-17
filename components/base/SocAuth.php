<?php

namespace app\components\base;

use Yii;
use yii\helpers\Json;

class SocAuth {
    public static function authorize($callback) {
        $token = Yii::$app->request->post('token');

        $query = [
            'token' => $token,
        ];

        $url = 'http://auth.alente.ru/auth?' . http_build_query($query);
        $result = file_get_contents($url);

        if (!empty($result)) {
            $result_arr = Json::decode($result);

            if ($result_arr['result'] == 'success') {
                $callback($result_arr);

                return true;
            }
        }

        return false;
    }
}