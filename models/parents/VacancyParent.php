<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\VacancyDirect;
use app\components\base\CActiveRecord;
use app\models\VacancyInfo;
/**
 * This is the model class for table "vacancy".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property integer $direct_id
 * @property VacancyDirect $direct
 * @property bool $public
 * @property integer $weight
 * @property VacancyInfo[] $infos
 * @property VacancyInfo[] $infos_real
 */
class VacancyParent extends CActiveRecord {
    public static function tableName()
    {
        return 'vacancy';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['direct_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'direct_id'], 'string', 'on' => 'search'],
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
            'direct_id' => 'Направление',
            'direct' => 'Направление',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getDirect() {
        return $this->hasOne(VacancyDirect::class, ['id' => 'direct_id']);
    }

    public function getInfos() {
        return $this->hasMany(\app\models\VacancyInfo::class, ['vacancy_id' => 'id']);
    }
    public function getInfos_real() {
        $res = $this->getInfos()->ordered()->published()->all();
        $this->populateRelation('infos_real', $res);

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

    public static $search_model_class = '\app\models\search\VacancySearch';
    public static $model_title = 'Вакансия';
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
    'direct_id' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\VacancyDirect',
      'list_template' => 'title',
      'linki1Variable' => 'direct',
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
    0 => 
    array (
      'variable' => 'infos',
      'sort' => '10',
      'model_id' => 'vacancy_id',
      'model' => 'app\\models\\VacancyInfo',
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