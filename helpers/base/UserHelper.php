<?php

namespace app\helpers\base;

use Yii;
use yii\web\Cookie;

class UserHelper {
    protected static $json_data = false;
    public static $data = false;
    private static $_inited = false;

    public static function init() {
        if (static::$_inited === false) {
            static::$_inited = true;
            if (Yii::$app->user->isGuest) {
                if (self::$data === false) {
                    $res = Yii::$app->request->cookies['site_params'];
                    if ($res != '') {
                        self::$data = json_decode($res, true);
                        self::$json_data = $res;
                    }
                }
            } else {
                self::$data = json_decode(Yii::$app->user->identity->cookieArray, true);
                self::$json_data = Yii::$app->user->identity->cookieArray;
            }

            if (self::$data === false) self::$data = [];
        }
    }

    public static function update() {
        if (self::$json_data != json_encode(self::$data)) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->response->cookies->add(new Cookie(array_merge([
                    'name' => 'site_params',
                    'value' => json_encode(self::$data),
                    'expire' => time() + 3600 * 24 * 7,
                ], !empty(Yii::$app->params['cookie_domain']) ? ['domain' => '.' . Yii::$app->params['cookie_domain']] : [])));
            } else {
                Yii::$app->user->identity->cookieArray = json_encode(self::$data);
                Yii::$app->user->identity->save(false, ['cookieArray']);
            }
        }
    }

    public static function setParam($variable, $value) {
        self::$data[$variable] = $value;
    }

    public static function getParam($variable, $default = false) {
        if (empty(self::$data[$variable])) return $default;
        return self::$data[$variable];
    }
}

?>