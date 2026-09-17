<?php
namespace app\models\forms;

use app\components\recaptcha\Recaptcha;
use app\models\RequestVacancy;

class RequestVacancyForm extends RequestVacancy {
    public $command = 'save';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['phone', 'name', 'email'], 'required'],
            ['file_input', 'file', 'maxSize' => 1024 * 1024 * 10],
        ]);
    }

    public function attributeHints()
    {
        return [
            'name' => 'Введите ваше ФИО',
            'phone' => '+7(___) ___-__-__',
            'email' => 'pochta@pochta.ru',
            'file_input' => 'Перетащите или загрузите резюме сюда',
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
        $this->email = "";
    }
}