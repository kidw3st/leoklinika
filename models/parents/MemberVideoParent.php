<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\Member;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "member_video".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $video
 * @property string $image
 * @property Image $image_obj
 * @property integer $member_id
 * @property Member $member
 * @property bool $public
 * @property integer $weight
 */
class MemberVideoParent extends CActiveRecord {
    public static function tableName()
    {
        return 'member_video';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'video', 'image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['video_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'mp4', 'on' => ['default', 'admin']],
            [['video_del', 'image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['member_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'member_id'], 'string', 'on' => 'search'],
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
            'video' => 'Видео',
            'video_input' => 'Видео',
            'image' => 'Обложка',
            'image_input' => 'Обложка',
            'member_id' => 'Сотрудник',
            'member' => 'Сотрудник',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getMember() {
        return $this->hasOne(Member::class, ['id' => 'member_id']);
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


    public $video_del = 0;
    public $video_input = 0;
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

    public static $search_model_class = '\app\models\search\MemberVideoSearch';
    public static $model_title = 'Видео';
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
    'video' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => NULL,
      'savePath' => '/up/membervideo/video',
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
      'savePath' => '/up/membervideo/image',
    ),
    'member_id' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Member',
      'list_template' => 'title',
      'linki1Variable' => 'member',
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