<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SystemUserGroup;
use app\components\base\CActiveRecord;
use app\models\SystemUserGroupModelFilter;
/**
 * This is the model class for table "system_user_group_model".
 *
 * @property integer $id
 * @property array $options
 * @property string $model
 * @property integer $user_group_id
 * @property SystemUserGroup $user_group
 * @property SystemUserGroupModelFilter[] $filters
 * @property SystemUserGroupModelFilter[] $filters_real
 */
class SystemUserGroupModelParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user_group_model';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['model'], 'required', 'on' => ['default', 'admin']],
            [['model'], 'string', 'max' => 70, 'on' => ['default', 'admin']],
            [['user_group_id'], 'integer', 'on' => ['default', 'admin']],

            [['model', 'user_group_id'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'model' => 'Модель',
            'model_val' => 'Модель',
            'user_group_id' => 'Группа пользователя',
            'user_group' => 'Группа пользователя',
        ]);
    }


    public function getUser_group() {
        return $this->hasOne(SystemUserGroup::class, ['id' => 'user_group_id']);
    }

    public function getFilters() {
        return $this->hasMany(\app\models\SystemUserGroupModelFilter::class, ['user_group_model_id' => 'id']);
    }
    public function getFilters_real() {
        $res = $this->getFilters()->all();
        $this->populateRelation('filters_real', $res);

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

    public static $search_model_class = '\app\models\search\SystemUserGroupModelSearch';
    public static $model_title = 'Доступ к модели';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'model' => 
    array (
      'sort' => 10,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'user_group_id' => 
    array (
      'sort' => 20,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUserGroup',
      'list_template' => 'title',
      'linki1Variable' => 'user_group',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
    0 => 
    array (
      'variable' => 'filters',
      'sort' => '10',
      'model_id' => 'user_group_model_id',
      'model' => 'app\\models\\SystemUserGroupModelFilter',
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