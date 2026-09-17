<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\Service;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "service_link".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $image
 * @property Image $image_obj
 * @property string $link
 * @property string $link_title
 * @property string $background_color
 * @property string $background_color_val
 * @property integer $service_id
 * @property Service $service
 * @property bool $public
 * @property integer $weight
 */
class ServiceLinkParent extends CActiveRecord {
    public static function tableName()
    {
        return 'service_link';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'image', 'link', 'link_title'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['background_color'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['service_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'link', 'link_title', 'service_id'], 'string', 'on' => 'search'],
            [['background_color'], 'string', 'max' => 50, 'on' => 'search'],
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
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'link_title' => 'Текст ссылки',
            'link_title_val' => 'Текст ссылки',
            'background_color' => 'Цвет фона',
            'service_id' => 'Услуга',
            'service' => 'Услуга',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getService() {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
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
    protected static $background_colorList = false;
    public static function background_colorList() {
        if (static::$background_colorList === false) {
            static::$background_colorList = [
                'dark' => Yii::t('app', 'Темный'),
                'light' => Yii::t('app', 'Светлый'),
            ];
        }
        return static::$background_colorList;
    }
    public function getBackground_color_val() {
        $items = static::background_colorList();
        if (!empty($items[$this->background_color])) return $items[$this->background_color];
        return '';
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\ServiceLinkSearch';
    public static $model_title = 'Баннер';
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
      'savePath' => '/up/servicelink/image',
    ),
    'link' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'link_title' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'background_color' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::background_colorList(),
    ),
    'service_id' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Service',
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