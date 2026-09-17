<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\CActiveRecord;
use app\models\SystemUserGroupModel;
/**
 * This is the model class for table "system_user_group".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property SystemUserGroupModel[] $models
 * @property SystemUserGroupModel[] $models_real
 */
class SystemUserGroupParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user_group';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title'], 'string', 'max' => 255, 'on' => ['default', 'admin']],

            [['title'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
        ]);
    }



    public function getModels() {
        return $this->hasMany(\app\models\SystemUserGroupModel::class, ['user_group_id' => 'id']);
    }
    public function getModels_real() {
        $res = $this->getModels()->all();
        $this->populateRelation('models_real', $res);

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

    public static $search_model_class = '\app\models\search\SystemUserGroupSearch';
    public static $model_title = 'Группа пользователя';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'title' => 
    array (
      'sort' => 10,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
    0 => 
    array (
      'variable' => 'models',
      'sort' => '10',
      'model_id' => 'user_group_id',
      'model' => 'app\\models\\SystemUserGroupModel',
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