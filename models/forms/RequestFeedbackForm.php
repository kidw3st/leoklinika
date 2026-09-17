<?php
namespace app\models\forms;

use app\components\recaptcha\Recaptcha;
use app\models\RequestFeedback;

class RequestFeedbackForm extends RequestFeedback {
    public $command = 'save';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Имя',
            'phone' => 'Номер телефона',
            'text' => 'Вопрос',
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['phone', 'name', 'text'], 'required'],
        ]);
    }

    public function attributeHints()
    {
        return [
            'name' => 'Введите ваше имя',
            'phone' => '+7(___) ___-__-__',
            'text' => 'Ваш вопрос или мнение',
        ];
    }

    public function beforeValidate()
    {
        $res = parent::beforeValidate();

        if ($res) {
            Recaptcha::check($this);
        }

        return $res;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->name = "";
        $this->phone = "";
        $this->text = "";
    }
}