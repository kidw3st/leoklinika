<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\models\SystemUser;
use app\components\base\Date;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "system_user_confirm".
 *
 * @property integer $id
 * @property array $options
 * @property integer $user_id
 * @property SystemUser $user
 * @property string $type
 * @property string $type_val
 * @property string $code
 * @property string $created_at
 * @property Date $created_at_obj
 * @property string $updated_at
 * @property Date $updated_at_obj
 */
class SystemUserConfirmParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user_confirm';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['user_id'], 'integer', 'on' => ['default', 'admin']],
            [['type'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['code'], 'string', 'max' => 8, 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['user_id', 'code', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
            [['type'], 'string', 'max' => 50, 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'user' => 'Пользователь',
            'type' => 'Тип',
            'code' => 'Код',
            'code_val' => 'Код',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
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


    protected static $typeList = false;
    public static function typeList() {
        if (static::$typeList === false) {
            static::$typeList = [
                'register_email' => Yii::t('app', 'Email при регистрации'),
                'register_phone' => Yii::t('app', 'Телефон при регистрации'),
                'pass_recover' => Yii::t('app', 'Восстановление пароля'),
            ];
        }
        return static::$typeList;
    }
    public function getType_val() {
        $items = static::typeList();
        if (!empty($items[$this->type])) return $items[$this->type];
        return '';
    }
    public function getCreated_at_input() {
        if (empty($this->created_at)) return '';

        return date('d.m.Y H:i:s', strtotime($this->created_at));
    }
    public function setCreated_at_input($value) {
        if (empty($value)) {
            $this->created_at = '';
        } else {
            $this->created_at = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    public function getCreated_at_obj() {
        return new Date($this->created_at);
    }
    public function getUpdated_at_input() {
        if (empty($this->updated_at)) return '';

        return date('d.m.Y H:i:s', strtotime($this->updated_at));
    }
    public function setUpdated_at_input($value) {
        if (empty($value)) {
            $this->updated_at = '';
        } else {
            $this->updated_at = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    public function getUpdated_at_obj() {
        return new Date($this->updated_at);
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        'timesBehavior' => [
            'class' => TimesBehavior::className(),
            'attributes' => array (
  'create' => 'created_at',
  'update' => 'updated_at',
),
        ],
        ]);
    }

    public static $search_model_class = '\app\models\search\SystemUserConfirmSearch';
    public static $model_title = 'Подтверждение пользователя';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'user_id' => 
    array (
      'sort' => 10,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUser',
      'list_template' => 'title',
      'linki1Variable' => 'user',
    ),
    'type' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::typeList(),
    ),
    'code' => 
    array (
      'sort' => 30,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'created_at' => 
    array (
      'sort' => 100010,
      'viewed' => true,
      'type' => 'datetime',
    ),
    'updated_at' => 
    array (
      'sort' => 100010,
      'type' => 'datetime',
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