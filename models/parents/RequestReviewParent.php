<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\components\base\Date;
use app\models\Member;
use app\components\base\Image;
use app\models\SystemNoticeEvent;;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "request_review".
 *
 * @property integer $id
 * @property array $options
 * @property string $name
 * @property string $text
 * @property string $text2
 * @property float $rating
 * @property string $source
 * @property string $theme
 * @property string $date
 * @property Date $date_obj
 * @property integer $member_id
 * @property Member $member
 * @property string $answer
 * @property string $answer_date
 * @property Date $answer_date_obj
 * @property string $phone
 * @property string $email
 * @property bool $public
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
class RequestReviewParent extends CActiveRecord {
    public static function tableName()
    {
        return 'request_review';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required', 'on' => ['default', 'admin']],
            [['name', 'source', 'theme', 'phone', 'seo_title', 'seo_keywords', 'og_title', 'og_image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['text'], 'string', 'max' => 2000, 'on' => ['default', 'admin']],
            [['text2', 'answer'], 'string', 'on' => ['default', 'admin']],
            [['rating'], 'number', 'on' => ['default', 'admin']],
            [['date_input', 'answer_date_input', 'created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],
            [['member_id'], 'integer', 'on' => ['default', 'admin']],
            [['email'], 'string', 'max' => 80, 'on' => ['default', 'admin']],
            [['email'], 'email', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],
            [['seo_description', 'og_description'], 'string', 'max' => 500, 'on' => ['default', 'admin']],
            [['og_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'jpg, png', 'on' => ['default', 'admin']],
            [['og_image_del'], 'boolean', 'on' => ['default', 'admin']],

            [['name', 'text', 'text2', 'source', 'theme', 'date', 'member_id', 'answer', 'answer_date', 'phone', 'email', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
            [['rating'], 'number', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'name' => 'Имя',
            'name_val' => 'Имя',
            'text' => 'Отзыв',
            'text_val' => 'Отзыв',
            'text2' => 'Текст подробнее',
            'text2_val' => 'Текст подробнее',
            'rating' => 'Оценка',
            'source' => 'Источник',
            'source_val' => 'Источник',
            'theme' => 'Тема отзыва',
            'theme_val' => 'Тема отзыва',
            'date' => 'Дата',
            'member_id' => 'Сотрудник',
            'member' => 'Сотрудник',
            'answer' => 'Ответ',
            'answer_val' => 'Ответ',
            'answer_date' => 'Дата ответа',
            'phone' => 'Телефон',
            'phone_val' => 'Телефон',
            'email' => 'Email',
            'public' => 'Публикация',
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


    public function getMember() {
        return $this->hasOne(Member::class, ['id' => 'member_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            SystemNoticeEvent::doEvent('request_review_created', [
                'item' => $this,
            ], 'Новая запись в таблице "Отзыв"');
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


    public function getDate_input() {
        if (empty($this->date)) return '';

        return date('d.m.Y H:i:s', strtotime($this->date));
    }
    public function setDate_input($value) {
        if (empty($value)) {
            $this->date = '';
        } else {
            $this->date = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    public function getDate_obj() {
        return new Date($this->date);
    }
    public function getAnswer_date_input() {
        if (empty($this->answer_date)) return '';

        return date('d.m.Y H:i:s', strtotime($this->answer_date));
    }
    public function setAnswer_date_input($value) {
        if (empty($value)) {
            $this->answer_date = '';
        } else {
            $this->answer_date = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    public function getAnswer_date_obj() {
        return new Date($this->answer_date);
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

    public static $search_model_class = '\app\models\search\RequestReviewSearch';
    public static $model_title = 'Отзыв';
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
    'text' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'text2' => 
    array (
      'sort' => 25,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'rating' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'source' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'theme' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'date' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'datetime',
    ),
    'member_id' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Member',
      'list_template' => 'title',
      'linki1Variable' => 'member',
      'link_ajax' => false,
    ),
    'answer' => 
    array (
      'sort' => 80,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'answer_date' => 
    array (
      'sort' => 90,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'datetime',
    ),
    'phone' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'email' => 
    array (
      'sort' => 110,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'email',
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
      'savePath' => '/up/requestreview/og_image',
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