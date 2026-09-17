<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Date;
use app\models\Filial;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "filial_workday".
 *
 * @property integer $id
 * @property array $options
 * @property string $date
 * @property Date $date_obj
 * @property string $times
 * @property integer $filial_id
 * @property Filial $filial
 */
class FilialWorkdayParent extends CActiveRecord {
    public static function tableName()
    {
        return 'filial_workday';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['date'], 'required', 'on' => ['default', 'admin']],
            [['date_input'], 'date', 'format' => 'php:d.m.Y', 'on' => ['default', 'admin']],
            [['times'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['filial_id'], 'integer', 'on' => ['default', 'admin']],

            [['date', 'times', 'filial_id'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'date' => 'Дата',
            'times' => 'Время работы',
            'times_val' => 'Время работы',
            'filial_id' => 'Филиал',
            'filial' => 'Филиал',
        ]);
    }


    public function getFilial() {
        return $this->hasOne(Filial::class, ['id' => 'filial_id']);
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


    public function getDate_input() {
        if (empty($this->date)) return '';

        return date('d.m.Y', strtotime($this->date));
    }
    public function setDate_input($value) {
        if (empty($value)) {
            $this->date = '';
        } else {
            $this->date = date('Y-m-d', strtotime($value));
        }
    }
    public function getDate_obj() {
        return new Date($this->date);
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\FilialWorkdaySearch';
    public static $model_title = 'Рабочий день (не по расписанию)';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'date' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'date',
    ),
    'times' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'filial_id' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Filial',
      'list_template' => 'title',
      'linki1Variable' => 'filial',
      'link_ajax' => false,
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