<?php
namespace app\models;

use Yii;
use app\models\parents\SystemUserGroupParent;
use yii\helpers\ArrayHelper;

class SystemUserGroup extends SystemUserGroupParent
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

    public static function criteria($criteria) {
        /** @var SystemUser $user */
        $user = Yii::$app->user->identity;
        if ($user->group) {
            /** @var SystemUserGroupModel $model */
            $model = $user->group->getModels()->andWhere(['model' => '\\' . $criteria->modelClass])->one();
            if ($model) {
                foreach ($model->filters as $filter) {
                    $columns = explode('.', $filter->column);
                    $last_column = array_pop($columns);

                    $values = ArrayHelper::getColumn($filter->values, 'value_id');

                    $criteria
                        ->joinWith(implode('.', $columns) . ' AS ' . implode('_', $columns))
                        ->andWhere([implode('_', $columns).'.'.$last_column => $values]);
                }
            }
        }
    }
}