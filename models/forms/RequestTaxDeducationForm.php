<?php
namespace app\models\forms;

use app\components\recaptcha\Recaptcha;
use app\models\RequestTaxDeduction;
use Yii;

class RequestTaxDeducationForm extends RequestTaxDeduction {
    public $command = 'save';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'type' => 'Тип плательщика',

            'card_number' => 'Введите номер амбулаторной карты',
            'email' => 'Укажите почту, на которую нужно выслать справку',
            'phone' => 'Введите ваш номер телефона',

            'base_passport' => 'Серия и номер паспорта',
            'base_passport_date_input' => 'Дата выдачи паспорта',
            'base_name' => 'Введите ваши ФИО',
            'base_birthday_input' => 'Введите дату рождения',
            'base_inn' => 'Введите ИНН пациента',
            'base_year' => 'За какой год / годы вы хотите получить справку',

            'patient_name' => 'ФИО пациента',
            'relation' => 'Родственная связь',
            'patient_inn' => 'ИНН пациента',
            'patient_birthday_input' => 'Дата рождения пациента',
            'patient_passport' => 'Серия, номер, паспорта пациента (или № свидетельства о рождении)',
            'patient_passport_date_input' => 'Дата выдачи паспорта пациента (или свидетельства о рождении)',

            'payer_passport' => 'Серия и номер паспорта',
            'payer_passport_date_input' => 'Дата выдачи паспорта',
            'payer_name' => 'ФИО',
            'payer_birthday_input' => 'Дата рождения',
            'payer_inn' => 'ИНН',
            'payer_year' => 'За какой год / годы вы хотите получить справку',
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['base_name', 'base_birthday_input', 'base_inn', 'base_year'], 'required', 'when' => function($model) { return $model->patient == '1'; }],
            [['patient_name', 'relation', 'patient_inn', 'patient_birthday_input', 'patient_passport', 'patient_passport_date_input', 'payer_name', 'payer_birthday_input', 'payer_inn', 'payer_year'], 'required', 'when' => function($model) { return $model->patient == '0'; }],
            [['email'], 'required', 'when' => function($model) { return $model->delivery_method == 'email'; }],

            [['base_passport', 'base_name', 'base_inn', 'base_year', 'payer_passport', 'payer_name', 'payer_inn', 'payer_year'], 'string', 'max' => 255],
            [['base_passport_date_input', 'base_birthday_input', 'payer_passport_date_input', 'payer_birthday_input'], 'date', 'format' => 'php:d.m.Y'],
        ]);
    }

    public function isAttributeRequired($attribute)
    {
        $required = parent::isAttributeRequired($attribute);

        if (in_array($attribute, [
            'base_name', 'base_birthday_input', 'base_inn', 'base_year',
            'patient_name', 'relation', 'patient_inn', 'patient_birthday_input', 'patient_passport', 'patient_passport_date_input', 'payer_name', 'payer_birthday_input', 'payer_inn', 'payer_year',
            'email',
        ])) $required = true;

        return $required;
    }

    public function attributeHints()
    {
        return [
            'patient' => 'Тип плательщика',
            'name' => 'Ваши ФИО',
            'birthday_input' => 'Дата рождения пациента',
            'inn' => 'ИИН пациента',
            'card_number' => 'Номер амбулаторной карты',
            'year' => 'Годы',
            'email' => 'pochta@pochta.ru',
            'phone' => '+7(___) ___-__-__',
            'passport' => 'Серия и номер паспорта',
            'passport_date_input' => 'Дата выдачи паспорта',

            'patient_name' => 'ФИО пациента',
            'relation' => 'Родственная связь',
            'patient_inn' => 'ИНН пациента',
            'patient_birthday_input' => 'Дата рождения пациента',
            'patient_passport' => 'Серия, номер, паспорта пациента (или № свидетельства о рождении)',
            'patient_passport_date_input' => 'Дата выдачи паспорта пациента (или свидетельства о рождении)',

            'payer_passport' => 'Серия и номер паспорта плательщика',
            'payer_passport_date_input' => 'Дата выдачи паспорта',
            'payer_name' => 'ФИО плательщика',
            'payer_birthday_input' => 'Дата рождения',
            'payer_inn' => 'ИНН плательщика',
            'payer_year' => 'Годы',
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
        $this->patient = "1";
        $this->name = "";
        $this->birthday_input = "";
        $this->inn = "";
        $this->card_number = "";
        $this->year = "";
        $this->email = "";
        $this->phone = "";
        $this->passport = "";
        $this->passport_date_input = "";
        $this->patient_name = "";
        $this->relation = "in_person";
        $this->patient_inn = "";
        $this->patient_birthday_input = "";
        $this->patient_passport = "";
        $this->patient_passport_date_input = "";
    }

    public function __get($name)
    {
        if (in_array($name, ['payer_passport', 'payer_passport_date_input', 'payer_name', 'payer_birthday_input', 'payer_inn', 'payer_year'])) {
            $new_name = str_replace('payer_', '', $name);
            return $this->$new_name;
        }

        if (in_array($name, ['base_passport', 'base_passport_date_input', 'base_name', 'base_birthday_input', 'base_inn', 'base_year'])) {
            $new_name = str_replace('base_', '', $name);
            return $this->$new_name;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, ['payer_passport', 'payer_passport_date_input', 'payer_name', 'payer_birthday_input', 'payer_inn', 'payer_year'])) {
            $new_name = str_replace('payer_', '', $name);
            if ($this->patient == '0') $this->$new_name = $value;
            return;
        }
        if (in_array($name, ['base_passport', 'base_passport_date_input', 'base_name', 'base_birthday_input', 'base_inn', 'base_year'])) {
            $new_name = str_replace('base_', '', $name);
            if ($this->patient == '1') $this->$new_name = $value;
            return;
        }

        parent::__set($name, $value);
    }

    public function load($data, $formName = null)
    {
        parent::load($data, $formName);
        $res = parent::load($data, $formName);

        $this->delivery_method = Yii::$app->request->post('delivery_method', false);

        return $res;
    }
}