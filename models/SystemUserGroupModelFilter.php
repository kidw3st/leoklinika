<?php
namespace app\models;

use app\components\base\CActiveRecord;
use Yii;
use app\models\parents\SystemUserGroupModelFilterParent;

class SystemUserGroupModelFilter extends SystemUserGroupModelFilterParent
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

        $res['fields']['column']['type'] = 'select';
        if ($model) {
            $res['fields']['column']['items'] = static::model_columns($model);
        }

        return $res;
    }

    /**
     * @param $model SystemUserGroupModelFilter
     * @return string
     */
    public static function model_columns($model) {
        $vars = [];

        /** @var CActiveRecord $className */
        $className = $model->user_group_model->model;
        $label = $className::$model_title;
        $vars[$label] = $className::getEventVariables('', true);

        return static::infoRecursive($vars);
    }

    private static function infoRecursive($vars, $label = '', $depth = 0) {
        $res = [];
        foreach ($vars as $k => $var) {
            if (is_array($var)) {
                $res = array_merge($res, static::infoRecursive($var, ($label?($label.'.'):'').$k, $depth+1));
            } else {
                $k = str_replace(['[[.', ']]'], ['', ''], $k);
                $res[$k] = str_repeat('-', $depth) . ' ' . $label . ' ' . $var;
            }
        }
        return $res;
    }

    public function getTitle() {
        return $this->column;
    }

    public function getColumn_val() {
        $options = static::getOptions($this);

        return !empty($options['fields']['column']['items'][$this->column])?$options['fields']['column']['items'][$this->column]:'Пусто';
    }
}