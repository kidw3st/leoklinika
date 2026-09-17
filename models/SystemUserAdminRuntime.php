<?php
namespace app\models;

use Yii;
use app\models\parents\SystemUserAdminRuntimeParent;

class SystemUserAdminRuntime extends SystemUserAdminRuntimeParent
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

    public static function getUserRuntime($classname) {
        $runtime = static::find()->where(['model' => $classname, 'user_id' => Yii::$app->user->id])->one();
        if (!$runtime) {
            $runtime = new static();
            $runtime->model = $classname;
            $runtime->user_id = Yii::$app->user->id;
        }

        return $runtime;
    }

    public function getSort() {
        $params = $this->params_obj;
        return $params['sort'];
    }

    public function setSort($value) {
        $params = $this->params_obj;

        $sorts = explode('-', $value);

        if (count($sorts) == 1) {
            $params['sort'] = [$sorts[0] => SORT_ASC];
        } else {
            $params['sort'] = [$sorts[1] => SORT_DESC];
        }

        $this->params_obj = $params;
    }

    public function getSort_val() {
        $res = [];

        foreach ($this->sort as $k => $v) {
            $res[] = $k . ' ' . ($v==SORT_ASC?'ASC':'DESC');
        }

        return implode(', ', $res);
    }
}