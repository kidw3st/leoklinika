<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\components\base\Date;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "email_stack".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $from
 * @property string $to
 * @property string $bcc
 * @property string $text
 * @property integer $priority
 * @property float $status
 * @property string $status_val
 * @property string $created_at
 * @property Date $created_at_obj
 * @property string $updated_at
 * @property Date $updated_at_obj
 */
class EmailStackParent extends CActiveRecord {
    public static function tableName()
    {
        return 'email_stack';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'from'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['to', 'bcc'], 'string', 'max' => 1000, 'on' => ['default', 'admin']],
            [['text'], 'string', 'on' => ['default', 'admin']],
            [['priority'], 'integer', 'on' => ['default', 'admin']],
            [['status'], 'number', 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['title', 'from', 'to', 'bcc', 'text', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
            [['priority'], 'integer', 'on' => 'search'],
            [['status'], 'number', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Тема',
            'title_val' => 'Тема',
            'from' => 'Отправитель',
            'from_val' => 'Отправитель',
            'to' => 'Получатель',
            'to_val' => 'Получатель',
            'bcc' => 'Копия',
            'bcc_val' => 'Копия',
            'text' => 'Содержимое',
            'text_val' => 'Содержимое',
            'priority' => 'Приоритет (1-10)',
            'status' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ]);
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


    protected static $statusList = false;
    public static function statusList() {
        if (static::$statusList === false) {
            static::$statusList = [
                1 => Yii::t('app', 'В обработке'),
                2 => Yii::t('app', 'Отправлено'),
                3 => Yii::t('app', 'Ошибка отправления'),
            ];
        }
        return static::$statusList;
    }
    public function getStatus_val() {
        $items = static::statusList();
        if (!empty($items[$this->status])) return $items[$this->status];
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

    public static $search_model_class = '\app\models\search\EmailStackSearch';
    public static $model_title = 'Стек писем';
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
    'from' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'to' => 
    array (
      'sort' => 30,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'bcc' => 
    array (
      'sort' => 40,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text' => 
    array (
      'sort' => 50,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'priority' => 
    array (
      'sort' => 60,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'status' => 
    array (
      'sort' => 70,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::statusList(),
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