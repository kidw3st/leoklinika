<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\behaviors\base\HandleBehavior;
use app\components\base\Image;
use app\components\base\Date;
use app\models\Service;
use app\components\base\CActiveRecord;
use app\models\ActionImage;
/**
 * This is the model class for table "action".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $title2
 * @property string $handle
 * @property string $image
 * @property Image $image_obj
 * @property string $image_detail
 * @property Image $image_detail_obj
 * @property string $active_from
 * @property Date $active_from_obj
 * @property string $active_to
 * @property Date $active_to_obj
 * @property float $price
 * @property float $price_old
 * @property integer $service_id
 * @property Service $service
 * @property string $description
 * @property string $button
 * @property string $text
 * @property string $text_2
 * @property string $profit
 * @property string $duration
 * @property bool $public
 * @property string $created_at
 * @property Date $created_at_obj
 * @property string $updated_at
 * @property Date $updated_at_obj
 * @property integer $weight
 * @property ActionImage[] $images
 * @property ActionImage[] $images_real
 */
class ActionParent extends CActiveRecord {
    public static function tableName()
    {
        return 'action';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'handle', 'image', 'image_detail', 'button', 'profit', 'duration'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['title2'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['image_input', 'image_detail_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del', 'image_detail_del'], 'boolean', 'on' => ['default', 'admin']],
            [['active_from_input', 'active_to_input', 'created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],
            [['price', 'price_old'], 'number', 'on' => ['default', 'admin']],
            [['prices_input', 'tags_input'], 'safe', 'on' => ['default', 'admin']],
            [['service_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['description', 'text', 'text_2'], 'string', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'title2', 'handle', 'active_from', 'active_to', 'service_id', 'description', 'button', 'text', 'text_2', 'profit', 'duration', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
            [['price', 'price_old'], 'number', 'on' => 'search'],
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
            'title2' => 'Текст для прайслиста',
            'title2_val' => 'Текст для прайслиста',
            'handle' => 'Алиас',
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'image_detail' => 'Изображение деталки',
            'image_detail_input' => 'Изображение деталки',
            'active_from' => 'Активность от',
            'active_to' => 'Активность до',
            'price' => 'Цена',
            'price_old' => 'Старая цена',
            'prices' => 'Цены из прайслиста',
            'prices_input' => 'Цены из прайслиста',
            'tags' => 'Теги',
            'tags_input' => 'Теги',
            'service_id' => 'Направление',
            'service' => 'Направление',
            'description' => 'Описание',
            'description_val' => 'Описание',
            'button' => 'Текст кнопки',
            'button_val' => 'Текст кнопки',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'text_2' => 'Текст 2',
            'text_2_val' => 'Текст 2',
            'profit' => 'Выгода',
            'profit_val' => 'Выгода',
            'duration' => 'Продолжительность',
            'duration_val' => 'Продолжительность',
            'public' => 'Публикация',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'weight' => 'Порядок',
        ]);
    }


    public function getService() {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public function getImages() {
        return $this->hasMany(\app\models\ActionImage::class, ['action_id' => 'id']);
    }
    public function getImages_real() {
        $res = $this->getImages()->ordered()->published()->all();
        $this->populateRelation('images_real', $res);

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


    public $image_del = 0;
    public $image_input = 0;
    public function getImage_obj() {
        return new Image($this->image);
    }
    public $image_detail_del = 0;
    public $image_detail_input = 0;
    public function getImage_detail_obj() {
        return new Image($this->image_detail);
    }
    public function getActive_from_input() {
        if (empty($this->active_from)) return '';

        return date('d.m.Y H:i:s', strtotime($this->active_from));
    }
    public function setActive_from_input($value) {
        if (empty($value)) {
            $this->active_from = '';
        } else {
            $this->active_from = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    public function getActive_from_obj() {
        return new Date($this->active_from);
    }
    public function getActive_to_input() {
        if (empty($this->active_to)) return '';

        return date('d.m.Y H:i:s', strtotime($this->active_to));
    }
    public function setActive_to_input($value) {
        if (empty($value)) {
            $this->active_to = '';
        } else {
            $this->active_to = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    public function getActive_to_obj() {
        return new Date($this->active_to);
    }
    private $_prices_input = false;

    public function getPrices_input() {
        if ($this->_prices_input === false) {
            $this->_prices_input = ArrayHelper::getColumn($this->prices, 'id');
        }
        return $this->_prices_input;
    }

    public function setPrices_input($value) {
        $this->_prices_input = $value;
    }

    public function getPrices() {
        return $this->hasMany(\app\models\ServicePrice::class, ['id' => 'price_id'])->viaTable('action2price', ['action_id' => 'id']);
    }
    private $_tags_input = false;

    public function getTags_input() {
        if ($this->_tags_input === false) {
            $this->_tags_input = ArrayHelper::getColumn($this->tags, 'id');
        }
        return $this->_tags_input;
    }

    public function setTags_input($value) {
        $this->_tags_input = $value;
    }

    public function getTags() {
        return $this->hasMany(\app\models\ActionTag::class, ['id' => 'tag_id'])->viaTable('action2tag', ['action_id' => 'id']);
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
        $this->_prices_input = false;
        $this->_tags_input = false;
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
            'handleBehavior' => [
                'class' => HandleBehavior::className(),
                'attributes' => array (
  'handle' => 'title',
),
            ],
        ]);
    }

    public static $search_model_class = '\app\models\search\ActionSearch';
    public static $model_title = 'Акция';
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
    'title2' => 
    array (
      'sort' => 15,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'handle' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'handle',
    ),
    'image' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/action/image',
    ),
    'image_detail' => 
    array (
      'sort' => 32,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/action/image_detail',
    ),
    'active_from' => 
    array (
      'sort' => 35,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'datetime',
    ),
    'active_to' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'datetime',
    ),
    'price' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'price_old' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'prices' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\ServicePrice',
      'link_table' => 'action2price',
      'link_id1' => 'action_id',
      'link_id2' => 'price_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'tags' => 
    array (
      'sort' => 80,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\ActionTag',
      'link_table' => 'action2tag',
      'link_id1' => 'action_id',
      'link_id2' => 'tag_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'service_id' => 
    array (
      'sort' => 90,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Service',
      'list_template' => 'title',
      'linki1Variable' => 'service',
      'link_ajax' => false,
    ),
    'description' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'button' => 
    array (
      'sort' => 110,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text' => 
    array (
      'sort' => 120,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'text_2' => 
    array (
      'sort' => 130,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'profit' => 
    array (
      'sort' => 140,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'duration' => 
    array (
      'sort' => 150,
      'locale' => 0,
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
    'created_at' => 
    array (
      'sort' => 100010,
      'locale' => 0,
      'viewed' => true,
      'type' => 'datetime',
    ),
    'updated_at' => 
    array (
      'sort' => 100010,
      'locale' => 0,
      'type' => 'datetime',
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
      'variable' => 'images',
      'sort' => '10',
      'model_id' => 'action_id',
      'model' => 'app\\models\\ActionImage',
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