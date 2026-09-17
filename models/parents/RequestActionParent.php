<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\models\PageBlock;
use app\components\base\Image;
use app\components\base\Date;
use app\models\SystemNoticeEvent;;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "request_action".
 *
 * @property integer $id
 * @property array $options
 * @property string $name
 * @property string $phone
 * @property integer $block_id
 * @property PageBlock $block
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $og_title
 * @property string $og_description
 * @property string $og_image
 * @property Image $og_image_obj
 * @property string $created_at
 * @property Date $created_at_obj
 * @property string $updated_at
 * @property Date $updated_at_obj
 */
class RequestActionParent extends CActiveRecord {
    public static function tableName()
    {
        return 'request_action';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'phone'], 'required', 'on' => ['default', 'admin']],
            [['name', 'phone', 'seo_title', 'seo_keywords', 'og_title', 'og_image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['name'], 'validateName', 'on' => ['default', 'admin']],
            [['block_id'], 'integer', 'on' => ['default', 'admin']],
            [['seo_description', 'og_description'], 'string', 'max' => 500, 'on' => ['default', 'admin']],
            [['og_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'jpg, png', 'on' => ['default', 'admin']],
            [['og_image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['name', 'phone', 'block_id', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'name' => 'Имя',
            'name_val' => 'Имя',
            'phone' => 'Телефон',
            'phone_val' => 'Телефон',
            'block_id' => 'Блок акции',
            'block' => 'Блок акции',
            'seo_title' => 'Seo title',
            'seo_title_val' => 'Seo title',
            'seo_description' => 'Seo description',
            'seo_description_val' => 'Seo description',
            'seo_keywords' => 'Seo keywords',
            'seo_keywords_val' => 'Seo keywords',
            'og_title' => 'Og title',
            'og_title_val' => 'Og title',
            'og_description' => 'Og description',
            'og_description_val' => 'Og description',
            'og_image' => 'Og image',
            'og_image_input' => 'Og image',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ]);
    }


    public function getBlock() {
        return $this->hasOne(PageBlock::class, ['id' => 'block_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            SystemNoticeEvent::doEvent('request_action_created', [
                'item' => $this,
            ], 'Новая запись в таблице "Заявка"');
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


    public $og_image_del = 0;
    public $og_image_input = 0;
    public function getOg_image_obj() {
        return new Image($this->og_image);
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
        ]);
    }

    public static $search_model_class = '\app\models\search\RequestActionSearch';
    public static $model_title = 'Заявка';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'name' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'phone' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'block_id' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\PageBlock',
      'list_template' => 'title',
      'linki1Variable' => 'block',
      'link_ajax' => false,
    ),
    'seo_title' => 
    array (
      'sort' => 100000,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'seo_description' => 
    array (
      'sort' => 100000,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'seo_keywords' => 
    array (
      'sort' => 100000,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'og_title' => 
    array (
      'sort' => 100000,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'og_description' => 
    array (
      'sort' => 100000,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'og_image' => 
    array (
      'sort' => 100000,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => true,
      'savePath' => '/up/requestaction/og_image',
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