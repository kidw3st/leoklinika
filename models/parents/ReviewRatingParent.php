<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "review_rating".
 *
 * @property integer $id
 * @property array $options
 * @property string $type
 * @property string $type_val
 * @property float $rating
 * @property string $link
 * @property bool $public
 * @property integer $weight
 */
class ReviewRatingParent extends CActiveRecord {
    public static function tableName()
    {
        return 'review_rating';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['type'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['rating'], 'number', 'on' => ['default', 'admin']],
            [['link'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],
            [['weight'], 'integer', 'on' => ['default', 'admin']],

            [['type'], 'string', 'max' => 50, 'on' => 'search'],
            [['rating'], 'number', 'on' => 'search'],
            [['link'], 'string', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'type' => 'Тип',
            'rating' => 'Рейтинг',
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'public' => 'Публикация',
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
                'prodoctorov' => Yii::t('app', 'ПроДокторов'),
                'yandex' => Yii::t('app', 'Яндекс.Карты'),
                '2gis' => Yii::t('app', '2ГИС'),
            ];
        }
        return static::$typeList;
    }
    public function getType_val() {
        $items = static::typeList();
        if (!empty($items[$this->type])) return $items[$this->type];
        return '';
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\ReviewRatingSearch';
    public static $model_title = 'Рейтинг внешнего источника';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'type' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::typeList(),
    ),
    'rating' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'link' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
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