<?php
namespace app\components\recaptcha;

use app\components\base\CActiveRecord;
use app\models\SystemSettings;
use Yii;
use yii\helpers\Html;
use yii\web\View;

class Recaptcha {
    /**
     * @param View $view
     */
    private static $_inited = false;

    public static function init($view) {
        if (!static::$_inited) {
            static::$_inited = true;
            RecaptchaAsset::register($view);

            $view->registerJs('var recaptcha_site_key = "' . Yii::$app->params['recaptcha']['site_key'] . '"', View::POS_END);
            $view->registerCss('.grecaptcha-badge { visibility: hidden; }');
        }
    }

    public static function input($register_view = false) {
        if (Yii::$app->params['recaptcha']['enable'] == false) return '';

        if ($register_view) static::init($register_view);
        return Html::hiddenInput('g-recaptcha-code');
    }

    private static $responces = [];
    /**
     * @param CActiveRecord $model
     */
    public static function check($model) {
        if (Yii::$app->params['recaptcha']['enable'] == false) return true;

        $code = Yii::$app->request->post('g-recaptcha-code', false);

        if ($code) {
            if (empty(static::$responces[$code])) {
                $params = array(
                    'secret' => Yii::$app->params['recaptcha']['secret_key'],
                    'response' => $code,
                );

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($curl);
                curl_close($curl);

                $result = json_decode($result, true);
                static::$responces[$code] = $result;
            }

            $result = static::$responces[$code];
            if (!empty($result['score']) && floatval($result['score']) > Yii::$app->params['recaptcha']['min_score']) {
                return true;
            }
        }

        $model->addError('form', SystemSettings::getParam('mail', 'recaptcha_error', 'Ошибка проверки кода'));
        return false;
    }

    public static function policy_text() {
        return SystemSettings::getParam('adminbase', 'recaptcha_terms', '<p>This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" rel="nofollow" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" rel="nofollow" target="_blank">Terms of Service apply</a>.</p>');
    }
}