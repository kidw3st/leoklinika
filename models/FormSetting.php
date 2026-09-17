<?php
namespace app\models;

use Yii;
use app\models\parents\FormSettingParent;

class FormSetting extends FormSettingParent
{
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['form_type'], 'unique'],
        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    /**
     * @param $handle
     * @return FormSetting|array|null|\yii\db\ActiveRecord
     */
    public static function getFormSettings($handle) {
        $form = FormSetting::find()->where(['form_type' => $handle])->one();
        if (!$form) {
            $form = new FormSetting();
            $form->form_type = $handle;
            $form->title = 'Заполнить';
            $form->save();
        }

        return $form;
    }
}