<?php
namespace app\models;

use app\helpers\base\SystemHelper;
use Yii;
use app\models\parents\LanguageParent;

class Language extends LanguageParent
{
    public $set_update_time = false;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
        
        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    public function getHandle_real() {
        if ($this->is_main) return '';

        return $this->handle;
    }

    public function getChangeUrl($params = []) {
        $buffLang = SystemHelper::Language();
        SystemHelper::setLanguage($this);
        if (Yii::$app->controller->route == 'site/error') {
            $params = array_merge(['site/index'], ['handle' => Yii::$app->request->pathInfo], $params);
        } else {
            $params = array_merge([Yii::$app->controller->route], Yii::$app->controller->actionParams, $params);
        }
        $params = array_diff($params, ['', false, null]);
        $res = Yii::$app->urlManager->createUrl($params);
        SystemHelper::setLanguage($buffLang);

        return $res;
    }
}