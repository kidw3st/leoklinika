<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $video
 */
class VideoParent extends CActiveRecord {
    public static function tableName()
    {
        return 'video';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'video'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['video_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'mp4', 'on' => ['default', 'admin']],
            [['video_del'], 'boolean', 'on' => ['default', 'admin']],

            [['title'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Имя',
            'title_val' => 'Имя',
            'video' => 'Видео',
            'video_input' => 'Видео',
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


    public $video_del = 0;
    public $video_input = 0;

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\VideoSearch';
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
      'savePath' => '/up/video/video',
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