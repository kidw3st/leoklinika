<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\ServiceBlock;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "service_block_item".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $text
 * @property string $description
 * @property string $image
 * @property Image $image_obj
 * @property string $link
 * @property string $link_title
 * @property string $block_color
 * @property string $block_color_val
 * @property string $title_modal
 * @property string $text_modal
 * @property integer $block_id
 * @property ServiceBlock $block
 * @property bool $public
 * @property string $image_alt
 * @property integer $weight
 */
class ServiceBlockItemParent extends CActiveRecord {
    public static function tableName()
    {
        return 'service_block_item';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'image', 'link', 'link_title', 'title_modal', 'image_alt'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['text', 'description', 'text_modal'], 'string', 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['block_color'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['block_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'text', 'description', 'link', 'link_title', 'title_modal', 'text_modal', 'block_id', 'image_alt'], 'string', 'on' => 'search'],
            [['block_color'], 'string', 'max' => 50, 'on' => 'search'],
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
            'description' => 'Описание',
            'description_val' => 'Описание',
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'link_title' => 'Текст ссылки',
            'link_title_val' => 'Текст ссылки',
            'block_color' => 'Цвет блока',
            'title_modal' => 'Заголовок модалки',
            'title_modal_val' => 'Заголовок модалки',
            'text_modal' => 'Текст модалки',
            'text_modal_val' => 'Текст модалки',
            'block_id' => 'Блок',
            'block' => 'Блок',
            'public' => 'Публикация',
            'image_alt' => 'Изображение (alt)',
            'image_alt_val' => 'Изображение (alt)',
            'weight' => 'Порядок',
        ]);
    }


    public function getBlock() {
        return $this->hasOne(ServiceBlock::class, ['id' => 'block_id']);
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
    protected static $block_colorList = false;
    public static function block_colorList() {
        if (static::$block_colorList === false) {
            static::$block_colorList = [
                'about' => Yii::t('app', 'Светлый'),
                'directions' => Yii::t('app', 'Синий'),
            ];
        }
        return static::$block_colorList;
    }
    public function getBlock_color_val() {
        $items = static::block_colorList();
        if (!empty($items[$this->block_color])) return $items[$this->block_color];
        return '';
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\ServiceBlockItemSearch';
    public static $model_title = 'Элемент';
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
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'description' => 
    array (
      'sort' => 22,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'image' => 
    array (
      'sort' => 24,
      'locale' => 0,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/serviceblockitem/image',
    ),
    'link' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'link_title' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'block_color' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'type' => 'select',
      'items' => static::block_colorList(),
    ),
    'title_modal' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text_modal' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'block_id' => 
    array (
      'sort' => 1000,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\ServiceBlock',
      'list_template' => 'title',
      'linki1Variable' => 'block',
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
      'sort' => 25,
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