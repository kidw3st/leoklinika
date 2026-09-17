<?php
namespace app\models\forms;

use app\components\recaptcha\Recaptcha;
use app\models\RequestReview;

class RequestReviewForm extends RequestReview {
    public $command = 'save';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Имя',
            'phone' => 'Номер телефона',
            'text' => 'Текст отзыва',
            'email' => 'Email',
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['text', 'name'], 'required'],
            [['phone', 'email'], 'string'],
        ]);
    }

    public function attributeHints()
    {
        return [
            'name' => 'Введите ваше ФИО',
            'text' => 'Введите текст отзыва',
            'phone' => '+7(___) ___-__-__',
            'email' => 'pochta@pochta.ru',
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

    public function beforeSave($insert)
    {
        $this->date_input = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->name = "";
        $this->text = "";
        $this->email = "";
        $this->phone = "";
    }
}