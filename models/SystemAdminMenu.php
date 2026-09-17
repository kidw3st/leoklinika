<?php
namespace app\models;

use Yii;
use app\models\parents\SystemAdminMenuParent;

class SystemAdminMenu extends SystemAdminMenuParent
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

    public function isPermissionsCan() {
        /** @var SystemUser $user */
        $user = Yii::$app->user->identity;
        if ($user->group && $this->model) {
            $model = $user->group->getModels()->andWhere(['model' => '\\app\\models\\' . $this->model])->one();
            if (!$model) return false;
        }

        return true;
    }

    public function getGenerate_url() {
        if (!empty($this->url)) return $this->url;
        if (!empty($this->model)) return '/admin/model/mod-'.$this->model.'/act-index';

        return '#';
    }

    public function getBasic_url() {
        return $this->generate_url;
    }

    public function getTitle_2() {
        return $this->title;
    }

    public function getTitle_3() {
        return $this->title;
    }
}