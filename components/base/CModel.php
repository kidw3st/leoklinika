<?php

namespace app\components\base;

use Yii;
use yii\base\Model;

class CModel extends Model {
    public $success = false;
    public $formNameSuffix = '';

    public function formNameWithVar($variable)
    {
        $vars = explode('[', $variable);
        $vars[0] = '[' . $vars[0] . ']';
        $vars = implode('[', $vars);

        return $this->formName() . $vars;
    }

    public static function getOptions() {
        return [
            'label' => 'Сущность',
        ];
    }

    public function getAttributeLabelWithRequired($attribute, $template = ' *') {
        return $this->getAttributeLabel($attribute) . ($this->isAttributeRequired($attribute)?$template:'');
    }

    public function loadAndSave() {
        if (Yii::$app->request->isPost && $this->load(Yii::$app->request->post()) && $this->save()) {
            $this->success = true;
            return true;
        }

        return false;
    }

    public function quick_load() {
        return Yii::$app->request->isPost && $this->load(Yii::$app->request->post());
    }

    public function save() {
        return true;
    }

    public function formName()
    {
        return parent::formName() . $this->formNameSuffix;
    }

    public function validateName($attribute, $params, $validator = false) {
        if (preg_match('/[0-9]/', $this->$attribute)) {
            $this->addError($attribute, 'Поле «'.$this->getAttributeLabel($attribute).'» не должно иметь цифр');
        }
    }

    public function validateLatin($attribute, $params, $validator = false) {
        if (preg_match('/[а-яА-ЯёЁ]/', $this->$attribute)) {
            $this->addError($attribute, 'Поле «'.$this->getAttributeLabel($attribute).'» не должно содержать кириллических символов');
        }
    }

    public function validateCheckSpam($attribute, $params, $validator = false) {
        $res = false;
        if (strpos($this->$attribute, '/') !== false) $res = true;
        if ($this->$attribute != strip_tags($this->$attribute)) $res = true;
        if (preg_match('/https?:\/\//', $this->$attribute)) $res = true;
        if (strpos($this->$attribute, '@') !== false) $res = true;

        if ($res) {
            $this->addError($attribute, 'В поле «'.$this->getAttributeLabel($attribute).'» ошибка');
        }
    }

    public static $eventCustomVariables = [];
    public static function getEventVariables($basicVar = '', $withII = false) {
        $vars = [];
        foreach(static::$eventCustomVariables as $k => $val) {
            $vars['[['.$basicVar.'.'.$k.']]'] = $val;
        }
        return $vars;
    }
}