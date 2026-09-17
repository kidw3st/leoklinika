<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\Video;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "form_setting".
 *
 * @property integer $id
 * @property array $options
 * @property string $form_name
 * @property string $form_type
 * @property string $title
 * @property string $description
 * @property string $image
 * @property Image $image_obj
 * @property string $link_title
 * @property integer $video_id
 * @property Video $video
 * @property string $success_text
 */
class FormSettingParent extends CActiveRecord {
    public static function tableName()
    {
        return 'form_setting';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['form_name', 'form_type', 'title', 'image', 'link_title', 'success_text'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['form_type', 'title'], 'required', 'on' => ['default', 'admin']],
            [['description'], 'string', 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['video_id'], 'integer', 'on' => ['default', 'admin']],

            [['form_name', 'form_type', 'title', 'description', 'link_title', 'video_id', 'success_text'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'form_name' => 'Название',
            'form_name_val' => 'Название',
            'form_type' => 'Код формы',
            'form_type_val' => 'Код формы',
            'title' => 'Заголовок',
            'title_val' => 'Заголовок',
            'description' => 'Описание',
            'description_val' => 'Описание',
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'link_title' => 'Текст кнопки',
            'link_title_val' => 'Текст кнопки',
            'video_id' => 'Видео',
            'video' => 'Видео',
            'success_text' => 'Текст успеха',
            'success_text_val' => 'Текст успеха',
        ]);
    }


    public function getVideo() {
        return $this->hasOne(Video::class, ['id' => 'video_id']);
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

    public static $search_model_class = '\app\models\search\FormSettingSearch';
    public static $model_title = 'Настройка формы';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'form_name' => 
    array (
      'sort' => 5,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'form_type' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'title' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'description' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'image' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/formsetting/image',
    ),
    'link_title' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'video_id' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Video',
      'list_template' => 'title',
      'linki1Variable' => 'video',
      'link_ajax' => false,
    ),
    'success_text' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
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