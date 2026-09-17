<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SystemAdminMenu;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "request_vacancy_file".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $file
 * @property integer $request_vacancy_id
 * @property SystemAdminMenu $request_vacancy
 */
class RequestVacancyFileParent extends CActiveRecord {
    public static function tableName()
    {
        return 'request_vacancy_file';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'file'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['file_input'], 'file', 'on' => ['default', 'admin']],
            [['file_del'], 'boolean', 'on' => ['default', 'admin']],
            [['request_vacancy_id'], 'integer', 'on' => ['default', 'admin']],

            [['title', 'request_vacancy_id'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'file' => 'Файл',
            'file_input' => 'Файл',
            'request_vacancy_id' => 'Резюму',
            'request_vacancy' => 'Резюму',
        ]);
    }


    public function getRequest_vacancy() {
        return $this->hasOne(SystemAdminMenu::class, ['id' => 'request_vacancy_id']);
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


    public $file_del = 0;
    public $file_input = 0;

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\RequestVacancyFileSearch';
    public static $model_title = 'Файл';
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
    'file' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => NULL,
      'savePath' => '/up/requestvacancyfile/file',
    ),
    'request_vacancy_id' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemAdminMenu',
      'list_template' => 'title',
      'linki1Variable' => 'request_vacancy',
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