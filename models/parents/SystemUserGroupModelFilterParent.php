<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SystemUserGroupModel;
use app\components\base\CActiveRecord;
use app\models\SystemUserGroupModelFilterValue;
/**
 * This is the model class for table "system_user_group_model_filter".
 *
 * @property integer $id
 * @property array $options
 * @property string $column
 * @property integer $user_group_model_id
 * @property SystemUserGroupModel $user_group_model
 * @property SystemUserGroupModelFilterValue[] $values
 * @property SystemUserGroupModelFilterValue[] $values_real
 */
class SystemUserGroupModelFilterParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user_group_model_filter';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['column'], 'required', 'on' => ['default', 'admin']],
            [['column'], 'string', 'max' => 70, 'on' => ['default', 'admin']],
            [['user_group_model_id'], 'integer', 'on' => ['default', 'admin']],

            [['column', 'user_group_model_id'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'column' => 'Поле',
            'column_val' => 'Поле',
            'user_group_model_id' => 'Доступ к модели',
            'user_group_model' => 'Доступ к модели',
        ]);
    }


    public function getUser_group_model() {
        return $this->hasOne(SystemUserGroupModel::class, ['id' => 'user_group_model_id']);
    }

    public function getValues() {
        return $this->hasMany(\app\models\SystemUserGroupModelFilterValue::class, ['user_group_model_filter_id' => 'id']);
    }
    public function getValues_real() {
        $res = $this->getValues()->all();
        $this->populateRelation('values_real', $res);

        return $res;
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

    public static $search_model_class = '\app\models\search\SystemUserGroupModelFilterSearch';
    public static $model_title = 'Фильтр модели';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'column' => 
    array (
      'sort' => 10,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'user_group_model_id' => 
    array (
      'sort' => 30,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUserGroupModel',
      'list_template' => 'model',
      'linki1Variable' => 'user_group_model',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
    0 => 
    array (
      'variable' => 'values',
      'sort' => '10',
      'model_id' => 'user_group_model_filter_id',
      'model' => 'app\\models\\SystemUserGroupModelFilterValue',
      'link_delete' => 'on',
    ),
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