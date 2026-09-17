<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\CActiveRecord;
use app\models\FilialWorkday;
use app\models\FilialImage;
/**
 * This is the model class for table "filial".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $city
 * @property string $address
 * @property string $phones
 * @property string $emails
 * @property array $times_obj
 * @property bool $is_default
 * @property float $coord_x
 * @property float $coord_y
 * @property bool $public
 * @property integer $weight
 * @property FilialWorkday[] $workdays
 * @property FilialWorkday[] $workdays_real
 * @property FilialImage[] $images
 * @property FilialImage[] $images_real
 */
class FilialParent extends CActiveRecord {
    public static function tableName()
    {
        return 'filial';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'city', 'address'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['city', 'address'], 'required', 'on' => ['default', 'admin']],
            [['phones'], 'string', 'max' => 2000, 'on' => ['default', 'admin']],
            [['emails'], 'string', 'on' => ['default', 'admin']],
            [['times'], 'safe', 'on' => ['default', 'admin']],
            [['is_default'], 'boolean', 'on' => ['default', 'admin']],
            [['coord_x', 'coord_y'], 'number', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],
            [['weight'], 'integer', 'on' => ['default', 'admin']],

            [['title', 'city', 'address', 'phones', 'emails'], 'string', 'on' => 'search'],
            [['is_default', 'public'], 'boolean', 'on' => 'search'],
            [['coord_x', 'coord_y'], 'number', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'city' => 'Город',
            'city_val' => 'Город',
            'address' => 'Адрес',
            'address_val' => 'Адрес',
            'phones' => 'Телефоны',
            'phones_val' => 'Телефоны',
            'emails' => 'Email',
            'emails_val' => 'Email',
            'times' => 'Время работы',
            'times_obj' => 'Время работы',
            'is_default' => 'По умолчанию',
            'coord_x' => 'Долгота',
            'coord_y' => 'Широта',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }



    public function getWorkdays() {
        return $this->hasMany(\app\models\FilialWorkday::class, ['filial_id' => 'id']);
    }
    public function getWorkdays_real() {
        $res = $this->getWorkdays()->all();
        $this->populateRelation('workdays_real', $res);

        return $res;
    }
    public function getImages() {
        return $this->hasMany(\app\models\FilialImage::class, ['filial_id' => 'id']);
    }
    public function getImages_real() {
        $res = $this->getImages()->ordered()->published()->all();
        $this->populateRelation('images_real', $res);

        return $res;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->is_default) {
            static::updateAll(['is_default' => 0], ['<>', 'id', $this->id]);
        }

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


    public function getTimes_obj() {
        return json_decode($this->times, true);
    }
    public function setTimes_obj(array $value) {
        $this->times = json_encode($value);
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\FilialSearch';
    public static $model_title = 'Филиал';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'title' => 
    array (
      'sort' => 5,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'city' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'address' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'phones' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'emails' => 
    array (
      'sort' => 35,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'times' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'type' => 'json',
    ),
    'is_default' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'coord_x' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'coord_y' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
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
      'variable' => 'workdays',
      'sort' => '10',
      'model_id' => 'filial_id',
      'model' => 'app\\models\\FilialWorkday',
      'link_delete' => 'on',
    ),
    1 => 
    array (
      'variable' => 'images',
      'sort' => '20',
      'model_id' => 'filial_id',
      'model' => 'app\\models\\FilialImage',
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