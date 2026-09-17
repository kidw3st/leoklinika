<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\behaviors\base\HandleBehavior;
use app\components\base\Image;
use app\models\MemberQualify;
use app\models\Video;
use app\components\base\Date;
use app\components\base\CActiveRecord;
use app\models\MemberImage;
use app\models\MemberVideo;
use app\models\MemberExpirience;
use app\models\MemberCertificate;
use app\models\RequestReview;
/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $handle
 * @property string $image
 * @property Image $image_obj
 * @property string $image_video
 * @property Image $image_video_obj
 * @property string $position
 * @property integer $qualify_id
 * @property MemberQualify $qualify
 * @property string $academic
 * @property string $specials
 * @property bool $is_lead
 * @property float $experience
 * @property string $title_seo
 * @property string $text_seo
 * @property string $text_spoiler
 * @property string $modal_image
 * @property Image $modal_image_obj
 * @property integer $modal_video_id
 * @property Video $modal_video
 * @property bool $direct_type_adult
 * @property bool $direct_type_child
 * @property string $education_main
 * @property string $education_intern
 * @property string $education_ordinat
 * @property string $education_aspirant
 * @property string $education_special
 * @property string $medflex_id
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
 * @property integer $weight
 * @property MemberImage[] $images
 * @property MemberImage[] $images_real
 * @property MemberVideo[] $videos
 * @property MemberVideo[] $videos_real
 * @property MemberExpirience[] $experiences
 * @property MemberExpirience[] $experiences_real
 * @property MemberCertificate[] $certificates
 * @property MemberCertificate[] $certificates_real
 * @property RequestReview[] $reviews
 * @property RequestReview[] $reviews_real
 */
class MemberParent extends CActiveRecord {
    public static function tableName()
    {
        return 'member';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'handle', 'image', 'image_video', 'position', 'academic', 'title_seo', 'modal_image', 'education_main', 'education_intern', 'education_ordinat', 'education_aspirant', 'education_special', 'medflex_id', 'seo_title', 'seo_keywords', 'og_title', 'og_image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['image_input', 'modal_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del', 'image_video_del', 'is_lead', 'modal_image_del', 'direct_type_adult', 'direct_type_child', 'og_image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['image_video_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'gif', 'on' => ['default', 'admin']],
            [['directs_input', 'filials_input'], 'safe', 'on' => ['default', 'admin']],
            [['qualify_id', 'modal_video_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['specials', 'text_seo', 'text_spoiler'], 'string', 'on' => ['default', 'admin']],
            [['experience'], 'number', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],
            [['seo_description', 'og_description'], 'string', 'max' => 500, 'on' => ['default', 'admin']],
            [['og_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'jpg, png', 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['title', 'handle', 'position', 'qualify_id', 'academic', 'specials', 'title_seo', 'text_seo', 'text_spoiler', 'modal_video_id', 'education_main', 'education_intern', 'education_ordinat', 'education_aspirant', 'education_special', 'medflex_id', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
            [['is_lead', 'direct_type_adult', 'direct_type_child', 'public'], 'boolean', 'on' => 'search'],
            [['experience'], 'number', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Имя',
            'title_val' => 'Имя',
            'handle' => 'Алиас',
            'image' => 'Фото',
            'image_input' => 'Фото',
            'image_video' => 'Видео (gif)',
            'image_video_input' => 'Видео (gif)',
            'directs' => 'Направления',
            'directs_input' => 'Направления',
            'position' => 'Должность',
            'position_val' => 'Должность',
            'qualify_id' => 'Квалификация',
            'qualify' => 'Квалификация',
            'academic' => 'Ученое звание',
            'academic_val' => 'Ученое звание',
            'specials' => 'Специализация',
            'specials_val' => 'Специализация',
            'filials' => 'Филиалы',
            'filials_input' => 'Филиалы',
            'is_lead' => 'Ведущий',
            'experience' => 'Опыт (лет)',
            'title_seo' => 'Заголовок сео блок',
            'title_seo_val' => 'Заголовок сео блок',
            'text_seo' => 'Текст сео блок',
            'text_seo_val' => 'Текст сео блок',
            'text_spoiler' => 'Текст сео блок под спойлером',
            'text_spoiler_val' => 'Текст сео блок под спойлером',
            'modal_image' => 'Изображение на форме',
            'modal_image_input' => 'Изображение на форме',
            'modal_video_id' => 'Видео на форме',
            'modal_video' => 'Видео на форме',
            'direct_type_adult' => 'Врачи и услуги',
            'direct_type_child' => 'Программы и чекапы',
            'education_main' => 'Образование',
            'education_main_val' => 'Образование',
            'education_intern' => 'Интернатура',
            'education_intern_val' => 'Интернатура',
            'education_ordinat' => 'Ординатура',
            'education_ordinat_val' => 'Ординатура',
            'education_aspirant' => 'Аспирантура',
            'education_aspirant_val' => 'Аспирантура',
            'education_special' => 'Специальность по диплому',
            'education_special_val' => 'Специальность по диплому',
            'medflex_id' => 'Ид medflex',
            'medflex_id_val' => 'Ид medflex',
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
            'weight' => 'Порядок',
        ]);
    }


    public function getQualify() {
        return $this->hasOne(MemberQualify::class, ['id' => 'qualify_id']);
    }
    public function getModal_video() {
        return $this->hasOne(Video::class, ['id' => 'modal_video_id']);
    }

    public function getImages() {
        return $this->hasMany(\app\models\MemberImage::class, ['member_id' => 'id']);
    }
    public function getImages_real() {
        $res = $this->getImages()->ordered()->published()->all();
        $this->populateRelation('images_real', $res);

        return $res;
    }
    public function getVideos() {
        return $this->hasMany(\app\models\MemberVideo::class, ['member_id' => 'id']);
    }
    public function getVideos_real() {
        $res = $this->getVideos()->ordered()->published()->all();
        $this->populateRelation('videos_real', $res);

        return $res;
    }
    public function getExperiences() {
        return $this->hasMany(\app\models\MemberExpirience::class, ['member_id' => 'id']);
    }
    public function getExperiences_real() {
        $res = $this->getExperiences()->published()->all();
        $this->populateRelation('experiences_real', $res);

        return $res;
    }
    public function getCertificates() {
        return $this->hasMany(\app\models\MemberCertificate::class, ['member_id' => 'id']);
    }
    public function getCertificates_real() {
        $res = $this->getCertificates()->ordered()->published()->all();
        $this->populateRelation('certificates_real', $res);

        return $res;
    }
    public function getReviews() {
        return $this->hasMany(\app\models\RequestReview::class, ['member_id' => 'id']);
    }
    public function getReviews_real() {
        $res = $this->getReviews()->published()->all();
        $this->populateRelation('reviews_real', $res);

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


    public $image_del = 0;
    public $image_input = 0;
    public function getImage_obj() {
        return new Image($this->image);
    }
    public $image_video_del = 0;
    public $image_video_input = 0;
    public function getImage_video_obj() {
        return new Image($this->image_video);
    }
    private $_directs_input = false;

    public function getDirects_input() {
        if ($this->_directs_input === false) {
            $this->_directs_input = ArrayHelper::getColumn($this->directs, 'id');
        }
        return $this->_directs_input;
    }

    public function setDirects_input($value) {
        $this->_directs_input = $value;
    }

    public function getDirects() {
        return $this->hasMany(\app\models\MemberDirect::class, ['id' => 'direct_id'])->viaTable('member2direct', ['member_id' => 'id']);
    }
    private $_filials_input = false;

    public function getFilials_input() {
        if ($this->_filials_input === false) {
            $this->_filials_input = ArrayHelper::getColumn($this->filials, 'id');
        }
        return $this->_filials_input;
    }

    public function setFilials_input($value) {
        $this->_filials_input = $value;
    }

    public function getFilials() {
        return $this->hasMany(\app\models\Filial::class, ['id' => 'filial_id'])->viaTable('member2filial', ['member_id' => 'id']);
    }
    public $modal_image_del = 0;
    public $modal_image_input = 0;
    public function getModal_image_obj() {
        return new Image($this->modal_image);
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
        $this->_directs_input = false;
        $this->_filials_input = false;
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
            'handleBehavior' => [
                'class' => HandleBehavior::className(),
                'attributes' => array (
  'handle' => 'title',
),
            ],
        ]);
    }

    public static $search_model_class = '\app\models\search\MemberSearch';
    public static $model_title = 'Сотрудник';
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
    'handle' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'handle',
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
      'savePath' => '/up/member/image',
    ),
    'image_video' => 
    array (
      'sort' => 35,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/member/image_video',
    ),
    'directs' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\MemberDirect',
      'link_table' => 'member2direct',
      'link_id1' => 'member_id',
      'link_id2' => 'direct_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'position' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'qualify_id' => 
    array (
      'sort' => 52,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\MemberQualify',
      'list_template' => 'title',
      'linki1Variable' => 'qualify',
      'link_ajax' => false,
    ),
    'academic' => 
    array (
      'sort' => 54,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'specials' => 
    array (
      'sort' => 56,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'filials' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\Filial',
      'link_table' => 'member2filial',
      'link_id1' => 'member_id',
      'link_id2' => 'filial_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'is_lead' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'experience' => 
    array (
      'sort' => 80,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'title_seo' => 
    array (
      'sort' => 90,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text_seo' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'text_spoiler' => 
    array (
      'sort' => 110,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'modal_image' => 
    array (
      'sort' => 120,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/member/modal_image',
    ),
    'modal_video_id' => 
    array (
      'sort' => 130,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Video',
      'list_template' => 'title',
      'linki1Variable' => 'modal_video',
      'link_ajax' => false,
    ),
    'direct_type_adult' => 
    array (
      'sort' => 140,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'direct_type_child' => 
    array (
      'sort' => 150,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'education_main' => 
    array (
      'sort' => 160,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'education_intern' => 
    array (
      'sort' => 170,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'education_ordinat' => 
    array (
      'sort' => 190,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'education_aspirant' => 
    array (
      'sort' => 200,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'education_special' => 
    array (
      'sort' => 210,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'medflex_id' => 
    array (
      'sort' => 220,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
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
      'savePath' => '/up/member/og_image',
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
      'variable' => 'images',
      'sort' => '10',
      'model_id' => 'member_id',
      'model' => 'app\\models\\MemberImage',
      'link_delete' => 'on',
    ),
    1 => 
    array (
      'variable' => 'videos',
      'sort' => '20',
      'model_id' => 'member_id',
      'model' => 'app\\models\\MemberVideo',
      'link_delete' => 'on',
    ),
    2 => 
    array (
      'variable' => 'experiences',
      'sort' => '30',
      'model_id' => 'member_id',
      'model' => 'app\\models\\MemberExpirience',
      'link_delete' => 'on',
    ),
    3 => 
    array (
      'variable' => 'certificates',
      'sort' => '40',
      'model_id' => 'member_id',
      'model' => 'app\\models\\MemberCertificate',
      'link_delete' => 'on',
    ),
    4 => 
    array (
      'variable' => 'reviews',
      'sort' => '50',
      'model_id' => 'member_id',
      'model' => 'app\\models\\RequestReview',
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