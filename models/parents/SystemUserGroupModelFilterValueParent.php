<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SystemUserAdminRuntime;
use app\models\SystemUserGroupModelFilter;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "system_user_group_model_filter_value".
 *
 * @property integer $id
 * @property array $options
 * @property integer $value_id
 * @property SystemUserAdminRuntime $value
 * @property integer $user_group_model_filter_id
 * @property SystemUserGroupModelFilter $user_group_model_filter
 */
class SystemUserGroupModelFilterValueParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user_group_model_filter_value';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['value_id'], 'required', 'on' => ['default', 'admin']],
            [['value_id', 'user_group_model_filter_id'], 'integer', 'on' => ['default', 'admin']],

            [['value_id', 'user_group_model_filter_id'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'value_id' => 'Значение',
            'value' => 'Значение',
            'user_group_model_filter_id' => 'Фильтр модели',
            'user_group_model_filter' => 'Фильтр модели',
        ]);
    }


    public function getValue() {
        return $this->hasOne(SystemUserAdminRuntime::class, ['id' => 'value_id']);
    }
    public function getUser_group_model_filter() {
        return $this->hasOne(SystemUserGroupModelFilter::class, ['id' => 'user_group_model_filter_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        parent::afterDelete();
    }

    public static function find()
    {
        $criteria = parent::find();
        return $criteria;
    }



    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\SystemUserGroupModelFilterValueSearch';
    public static $model_title = 'Значение фильтра';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'value_id' => 
    array (
      'sort' => 10,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUserAdminRuntime',
      'list_template' => 'title',
      'linki1Variable' => 'value',
    ),
    'user_group_model_filter_id' => 
    array (
      'sort' => 20,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUserGroupModelFilter',
      'list_template' => 'column',
      'linki1Variable' => 'user_group_model_filter',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
  ),
  'sti' => '1',
  'tree' => '0',
);

        if (!empty($options['children'])) {
            foreach ($options['children'] as $chKey => $chVal) {
                $options['children'][$chKey]['model'] = $chVal['model'];
            }
        }

        return ArrayHelper::merge(parent::getOptions($model), $options);
    }
}