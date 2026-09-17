<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Vacancy;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "vacancy_info".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $text
 * @property integer $vacancy_id
 * @property Vacancy $vacancy
 * @property bool $public
 * @property integer $weight
 */
class VacancyInfoParent extends CActiveRecord {
    public static function tableName()
    {
        return 'vacancy_info';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['text'], 'string', 'on' => ['default', 'admin']],
            [['vacancy_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'text', 'vacancy_id'], 'string', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'vacancy_id' => 'Вакансия',
            'vacancy' => 'Вакансия',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getVacancy() {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
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

    public static $search_model_class = '\app\models\search\VacancyInfoSearch';
    public static $model_title = 'Информация';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'title' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'vacancy_id' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Vacancy',
      'list_template' => 'title',
      'linki1Variable' => 'vacancy',
      'link_ajax' => false,
    ),
    'public' => 
    array (
      'sort' => 100030,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'weight' => 
    array (
      'sort' => 100020,
      'locale' => 0,
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