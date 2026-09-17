<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "system_settings".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $module
 * @property string $code
 * @property float $type
 * @property string $type_val
 * @property string $value
 * @property string $model_class
 * @property string $model_class_val
 * @property float $value_model
 * @property string $value_model_val
 * @property string $value_file
 * @property array $options_obj
 * @property integer $weight
 */
class SystemSettingsParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_settings';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'module', 'code'], 'required', 'on' => ['default', 'admin']],
            [['title', 'module', 'code', 'value_file'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['type', 'value_model'], 'number', 'on' => ['default', 'admin']],
            [['value'], 'string', 'on' => ['default', 'admin']],
            [['model_class'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['value_file_input'], 'file', 'on' => ['default', 'admin']],
            [['value_file_del'], 'boolean', 'on' => ['default', 'admin']],
            [['options'], 'safe', 'on' => ['default', 'admin']],
            [['weight'], 'integer', 'on' => ['default', 'admin']],

            [['title', 'module', 'code', 'value'], 'string', 'on' => 'search'],
            [['type', 'value_model'], 'number', 'on' => 'search'],
            [['model_class'], 'string', 'max' => 50, 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'module' => 'Модуль',
            'module_val' => 'Модуль',
            'code' => 'Код',
            'code_val' => 'Код',
            'type' => 'Тип',
            'value' => 'Значение',
            'value_val' => 'Значение',
            'model_class' => 'Класс модели',
            'value_model' => 'Значение',
            'value_file' => 'Файл',
            'value_file_input' => 'Файл',
            'options' => 'Элементы',
            'options_obj' => 'Элементы',
            'weight' => 'Порядок',
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


    protected static $typeList = false;
    public static function typeList() {
        if (static::$typeList === false) {
            static::$typeList = [
                1 => Yii::t('app', 'Строка'),
                2 => Yii::t('app', 'Текстовый блок'),
                3 => Yii::t('app', 'Визуальный редактор'),
                4 => Yii::t('app', 'Файл'),
                5 => Yii::t('app', 'Модель'),
                6 => Yii::t('app', 'Список'),
            ];
        }
        return static::$typeList;
    }
    public function getType_val() {
        $items = static::typeList();
        if (!empty($items[$this->type])) return $items[$this->type];
        return '';
    }
    protected static $model_classList = false;
    public static function model_classList() {
        if (static::$model_classList === false) {
            static::$model_classList = [
                '0' => Yii::t('app', ''),
            ];
        }
        return static::$model_classList;
    }
    public function getModel_class_val() {
        $items = static::model_classList();
        if (!empty($items[$this->model_class])) return $items[$this->model_class];
        return '';
    }
    protected static $value_modelList = false;
    public static function value_modelList() {
        if (static::$value_modelList === false) {
            static::$value_modelList = [
                0 => Yii::t('app', ''),
            ];
        }
        return static::$value_modelList;
    }
    public function getValue_model_val() {
        $items = static::value_modelList();
        if (!empty($items[$this->value_model])) return $items[$this->value_model];
        return '';
    }
    public $value_file_del = 0;
    public $value_file_input = 0;
    public function getOptions_obj() {
        return json_decode($this->options, true);
    }
    public function setOptions_obj(array $value) {
        $this->options = json_encode($value);
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\SystemSettingsSearch';
    public static $model_title = 'Настройки';
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
    'module' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
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
    'type' => 
    array (
      'sort' => 40,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::typeList(),
    ),
    'value' => 
    array (
      'sort' => 45,
      'type' => 'string',
      'editor' => 'input',
    ),
    'model_class' => 
    array (
      'sort' => 50,
      'type' => 'select',
      'items' => static::model_classList(),
    ),
    'value_model' => 
    array (
      'sort' => 60,
      'type' => 'select',
      'items' => static::value_modelList(),
    ),
    'value_file' => 
    array (
      'sort' => 70,
      'type' => 'file',
      'isImage' => NULL,
      'savePath' => '/up/systemsettings/value_file',
    ),
    'options' => 
    array (
      'sort' => 80,
      'type' => 'json',
    ),
    'weight' => 
    array (
      'sort' => 100020,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
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