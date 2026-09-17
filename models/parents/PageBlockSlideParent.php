<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\PageBlock;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "page_block_slide".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $image
 * @property Image $image_obj
 * @property string $image_mobile
 * @property Image $image_mobile_obj
 * @property string $text
 * @property string $link
 * @property string $link_title
 * @property integer $page_block_id
 * @property PageBlock $page_block
 * @property bool $public
 * @property integer $weight
 */
class PageBlockSlideParent extends CActiveRecord {
    public static function tableName()
    {
        return 'page_block_slide';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title'], 'string', 'max' => 100, 'on' => ['default', 'admin']],
            [['image_input', 'image_mobile_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image', 'image_mobile', 'link', 'link_title'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['image_del', 'image_mobile_del'], 'boolean', 'on' => ['default', 'admin']],
            [['text'], 'string', 'max' => 200, 'on' => ['default', 'admin']],
            [['page_block_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'text', 'link', 'link_title', 'page_block_id'], 'string', 'on' => 'search'],
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
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'image_mobile' => 'Изображение (адаптив)',
            'image_mobile_input' => 'Изображение (адаптив)',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'link_title' => 'Текст ссылки',
            'link_title_val' => 'Текст ссылки',
            'page_block_id' => 'Блок',
            'page_block' => 'Блок',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getPage_block() {
        return $this->hasOne(PageBlock::class, ['id' => 'page_block_id']);
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
    public $image_mobile_del = 0;
    public $image_mobile_input = 0;
    public function getImage_mobile_obj() {
        return new Image($this->image_mobile);
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\PageBlockSlideSearch';
    public static $model_title = 'Слайд';
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
    'image' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/pageblockslide/image',
    ),
    'image_mobile' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/pageblockslide/image_mobile',
    ),
    'text' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'link' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'link_title' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'page_block_id' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\PageBlock',
      'list_template' => 'title',
      'linki1Variable' => 'page_block',
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