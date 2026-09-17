<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\HandleBehavior;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $handle
 * @property string $short_title
 * @property bool $is_main
 * @property string $i18n_code
 * @property integer $weight
 * @property bool $public
 */
class LanguageParent extends CActiveRecord {
    public static function tableName()
    {
        return 'language';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'handle'], 'required', 'on' => ['default', 'admin']],
            [['title', 'handle', 'short_title', 'i18n_code'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['is_main'], 'boolean', 'on' => ['default', 'admin']],
            [['weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'handle', 'short_title', 'i18n_code'], 'string', 'on' => 'search'],
            [['is_main', 'public'], 'boolean', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'handle' => 'Алиас',
            'short_title' => 'Короткое название',
            'short_title_val' => 'Короткое название',
            'is_main' => 'Основной',
            'i18n_code' => 'Код локализации',
            'i18n_code_val' => 'Код локализации',
            'weight' => 'Порядок',
            'public' => 'Публикация',
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



    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'handleBehavior' => [
                'class' => HandleBehavior::className(),
                'attributes' => array (
  'handle' => 'title',
),
            ],
        ]);
    }

    public static $search_model_class = '\app\models\search\LanguageSearch';
    public static $model_title = 'Язык';
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
    'handle' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'handle',
    ),
    'short_title' => 
    array (
      'sort' => 25,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'is_main' => 
    array (
      'sort' => 30,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'i18n_code' => 
    array (
      'sort' => 50,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'weight' => 
    array (
      'sort' => 100020,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'public' => 
    array (
      'sort' => 100030,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
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