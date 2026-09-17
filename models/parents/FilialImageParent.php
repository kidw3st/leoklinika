<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\Filial;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "filial_image".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $image
 * @property Image $image_obj
 * @property integer $filial_id
 * @property Filial $filial
 * @property bool $public
 * @property integer $weight
 */
class FilialImageParent extends CActiveRecord {
    public static function tableName()
    {
        return 'filial_image';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['filial_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'filial_id'], 'string', 'on' => 'search'],
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
            'filial_id' => 'Филиал',
            'filial' => 'Филиал',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getFilial() {
        return $this->hasOne(Filial::class, ['id' => 'filial_id']);
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

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\FilialImageSearch';
    public static $model_title = 'Изображение';
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
      'savePath' => '/up/filialimage/image',
    ),
    'filial_id' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Filial',
      'list_template' => 'title',
      'linki1Variable' => 'filial',
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