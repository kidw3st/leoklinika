<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\SystemAdminMenu;
use app\components\base\CActiveRecord;
use app\models\ServiceBlockItem;
/**
 * This is the model class for table "service_block".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $block_type
 * @property string $block_type_val
 * @property string $text
 * @property string $image
 * @property Image $image_obj
 * @property string $link
 * @property string $link_title
 * @property string $block_class
 * @property string $block_class_val
 * @property integer $service_id
 * @property SystemAdminMenu $service
 * @property bool $public
 * @property string $image_alt
 * @property integer $weight
 * @property ServiceBlockItem[] $items
 * @property ServiceBlockItem[] $items_real
 */
class ServiceBlockParent extends CActiveRecord {
    public static function tableName()
    {
        return 'service_block';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'image', 'link', 'link_title', 'image_alt'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['block_type', 'block_class'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['text'], 'string', 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['service_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'text', 'link', 'link_title', 'service_id', 'image_alt'], 'string', 'on' => 'search'],
            [['block_type', 'block_class'], 'string', 'max' => 50, 'on' => 'search'],
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
            'block_type' => 'Тип блока',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'link_title' => 'Текст ссылки',
            'link_title_val' => 'Текст ссылки',
            'block_class' => 'Тип',
            'service_id' => 'Услуга',
            'service' => 'Услуга',
            'public' => 'Публикация',
            'image_alt' => 'Изображение (alt)',
            'image_alt_val' => 'Изображение (alt)',
            'weight' => 'Порядок',
        ]);
    }


    public function getService() {
        return $this->hasOne(SystemAdminMenu::class, ['id' => 'service_id']);
    }

    public function getItems() {
        return $this->hasMany(\app\models\ServiceBlockItem::class, ['block_id' => 'id']);
    }
    public function getItems_real() {
        $res = $this->getItems()->ordered()->published()->all();
        $this->populateRelation('items_real', $res);

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


    protected static $block_typeList = false;
    public static function block_typeList() {
        if (static::$block_typeList === false) {
            static::$block_typeList = [
                'text' => Yii::t('app', 'Текст'),
                'text2' => Yii::t('app', 'Текст 2'),
                'texts' => Yii::t('app', 'Плашки текста'),
                'texts2' => Yii::t('app', 'Плашки текста 2'),
                'links' => Yii::t('app', 'Ссылки'),
                'form_consult' => Yii::t('app', 'Форма консультации'),
                'pricelist' => Yii::t('app', 'Прайс-лист'),
            ];
        }
        return static::$block_typeList;
    }
    public function getBlock_type_val() {
        $items = static::block_typeList();
        if (!empty($items[$this->block_type])) return $items[$this->block_type];
        return '';
    }
    public $image_del = 0;
    public $image_input = 0;
    public function getImage_obj() {
        return new Image($this->image);
    }
    protected static $block_classList = false;
    public static function block_classList() {
        if (static::$block_classList === false) {
            static::$block_classList = [
                '0' => Yii::t('app', ''),
            ];
        }
        return static::$block_classList;
    }
    public function getBlock_class_val() {
        $items = static::block_classList();
        if (!empty($items[$this->block_class])) return $items[$this->block_class];
        return '';
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\ServiceBlockSearch';
    public static $model_title = 'Блок';
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
    'block_type' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::block_typeList(),
    ),
    'text' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'image' => 
    array (
      'sort' => 35,
      'locale' => 0,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/serviceblock/image',
    ),
    'link' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'link_title' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'block_class' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'type' => 'select',
      'items' => static::block_classList(),
    ),
    'service_id' => 
    array (
      'sort' => 1000,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemAdminMenu',
      'list_template' => 'title',
      'linki1Variable' => 'service',
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
    'image_alt' => 
    array (
      'sort' => 36,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
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
      'variable' => 'items',
      'sort' => '10',
      'model_id' => 'block_id',
      'model' => 'app\\models\\ServiceBlockItem',
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