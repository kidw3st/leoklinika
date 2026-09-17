<?php

namespace app\helpers\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class FormHelper {
    public static function csrf() {
        return Html::input('hidden', Yii::$app->request->csrfParam, Yii::$app->request->csrfToken);
    }

    /**
     * @param $model CActiveRecord
     * @param $template string
     */
    public static function errors($model, $attribute = false, $template = '<div class="error"><p>[content]</p></div>', $glue = '</p><p>')
    {
        if ($attribute === false) {
            if ($model->hasErrors()) {
                return str_replace('[content]', implode($glue, $model->firstErrors), $template);
            }
        } else {
            if ($model->hasErrors($attribute)) {
                return str_replace('[content]', implode($glue, $model->getErrors($attribute)), $template);
            }
        }

        return '';
    }

    public static function error($model, $attribute, $template = '<div class="error">[content]</div>')
    {
        if ($model->hasErrors($attribute)) {
            return str_replace('[content]', $model->getFirstError($attribute), $template);
        }

        return '';
    }

    public static function getAttribute($model, $attribute) {
        $attr = $attribute;
        $attr = preg_replace('/\[\]/', '', $attr);
        $attr = preg_replace('/\[(.*?)\]/', '.$1', $attr);

        return ArrayHelper::getValue($model, $attr, false);
    }
}