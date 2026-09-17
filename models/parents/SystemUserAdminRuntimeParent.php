<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SystemUser;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "system_user_admin_runtime".
 *
 * @property integer $id
 * @property array $options
 * @property string $model
 * @property integer $user_id
 * @property SystemUser $user
 * @property array $params_obj
 */
class SystemUserAdminRuntimeParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user_admin_runtime';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['model'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['user_id'], 'integer', 'on' => ['default', 'admin']],
            [['params'], 'safe', 'on' => ['default', 'admin']],

            [['model', 'user_id'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'model' => 'Модель',
            'model_val' => 'Модель',
            'user_id' => 'Пользователь',
            'user' => 'Пользователь',
            'params' => 'Параметры',
            'params_obj' => 'Параметры',
        ]);
    }


    public function getUser() {
        return $this->hasOne(SystemUser::class, ['id' => 'user_id']);
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


    public function getParams_obj() {
        return json_decode($this->params, true);
    }
    public function setParams_obj(array $value) {
        $this->params = json_encode($value);
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\SystemUserAdminRuntimeSearch';
    public static $model_title = 'Данные пользователя в админке';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'model' => 
    array (
      'sort' => 10,
      'type' => 'string',
      'editor' => 'input',
    ),
    'user_id' => 
    array (
      'sort' => 20,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUser',
      'list_template' => 'title',
      'linki1Variable' => 'user',
    ),
    'params' => 
    array (
      'sort' => 30,
      'type' => 'json',
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