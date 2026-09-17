<?php
namespace app\models;

use app\helpers\base\AdminHelper;
use Yii;
use app\models\parents\SystemUserGroupModelParent;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class SystemUserGroupModel extends SystemUserGroupModelParent
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

        $res['fields']['model']['type'] = 'select';
        $res['fields']['model']['items'] = static::modelList();

        $res['children'] = [];

        return $res;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!empty(Yii::$app->cache)) {
            TagDependency::invalidate(Yii::$app->cache, 'tree');
        }
    }

    public static function modelList() {
        $models = ArrayHelper::map(AdminHelper::getModels(), 'classChild', 'label');
        $settings = AdminHelper::getSettings();

        $res = array_merge($models, $settings);

        unset($res['\\'.SystemUserGroupModelFilter::class]);
        unset($res['\\'.SystemUserGroupModelFilterValue::class]);

        return $res;
    }

    public function getTitle() {
        return $this->model;
    }

    public function getModel_val() {
        $models = static::modelList();
        return empty($models[$this->model])?'Пусто':$models[$this->model];
    }
}