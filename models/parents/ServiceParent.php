<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\behaviors\base\HandleBehavior;
use app\components\base\Image;
use app\components\base\Date;
use app\components\base\CActiveRecordTree;
use app\models\ServiceLink;
use app\models\ServicePrice;
use app\models\ServiceImage;
use app\models\ServiceVideo;
use app\models\Faq;
use app\models\ServiceBlock;
/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $handle
 * @property string $icon
 * @property Image $icon_obj
 * @property string $image
 * @property Image $image_obj
 * @property string $type
 * @property string $type_val
 * @property bool $is_popular
 * @property string $image_2
 * @property Image $image_2_obj
 * @property string $image_3
 * @property Image $image_3_obj
 * @property string $text_title
 * @property string $text
 * @property string $members_title
 * @property string $title_seo
 * @property string $text_seo
 * @property string $text_spoiler
 * @property string $intro_text
 * @property string $intro_image
 * @property Image $intro_image_obj
 * @property string $discount_title
 * @property float $discount_price
 * @property float $discount_price_old
 * @property string $discount_button
 * @property float $price
 * @property bool $price_from
 * @property float $lvl
 * @property string $lvl_val
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
 * @property string $handle_tree
 * @property ServiceLink[] $links
 * @property ServiceLink[] $links_real
 * @property ServicePrice[] $prices
 * @property ServicePrice[] $prices_real
 * @property ServiceImage[] $images
 * @property ServiceImage[] $images_real
 * @property ServiceVideo[] $videos
 * @property ServiceVideo[] $videos_real
 * @property Faq[] $faqs
 * @property Faq[] $faqs_real
 * @property ServiceBlock[] $blocks
 * @property ServiceBlock[] $blocks_real
 */
class ServiceParent extends CActiveRecordTree {
    public static function tableName()
    {
        return 'service';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'handle', 'icon', 'image', 'image_2', 'image_3', 'text_title', 'members_title', 'title_seo', 'intro_image', 'discount_title', 'discount_button', 'seo_title', 'seo_keywords', 'og_title', 'og_image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['icon_input', 'image_input', 'image_2_input', 'image_3_input', 'intro_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['icon_del', 'image_del', 'is_popular', 'image_2_del', 'image_3_del', 'intro_image_del', 'price_from', 'og_image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['type'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['tags_input', 'members_input', 'related_services_input', 'filials_input'], 'safe', 'on' => ['default', 'admin']],
            [['text', 'text_seo', 'text_spoiler', 'intro_text'], 'string', 'on' => ['default', 'admin']],
            [['discount_price', 'discount_price_old', 'price', 'lvl'], 'number', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],
            [['seo_description', 'og_description', 'handle_tree'], 'string', 'max' => 500, 'on' => ['default', 'admin']],
            [['og_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'jpg, png', 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['title', 'handle', 'text_title', 'text', 'members_title', 'title_seo', 'text_seo', 'text_spoiler', 'intro_text', 'discount_title', 'discount_button', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at', 'handle_tree'], 'string', 'on' => 'search'],
            [['type'], 'string', 'max' => 50, 'on' => 'search'],
            [['is_popular', 'price_from', 'public'], 'boolean', 'on' => 'search'],
            [['discount_price', 'discount_price_old', 'price', 'lvl'], 'number', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'handle' => 'Алиас',
            'icon' => 'Иконка',
            'icon_input' => 'Иконка',
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'type' => 'Тип',
            'is_popular' => 'Популярная услуга',
            'tags' => 'Теги',
            'tags_input' => 'Теги',
            'image_2' => 'Баннер',
            'image_2_input' => 'Баннер',
            'image_3' => 'Баннер адаптив',
            'image_3_input' => 'Баннер адаптив',
            'text_title' => 'Заголовок текста',
            'text_title_val' => 'Заголовок текста',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'members_title' => 'Заголовок врачей',
            'members_title_val' => 'Заголовок врачей',
            'members' => 'Врачи',
            'members_input' => 'Врачи',
            'related_services' => 'Сопутствующие услуги',
            'related_services_input' => 'Сопутствующие услуги',
            'title_seo' => 'Заголовок сео блок',
            'title_seo_val' => 'Заголовок сео блок',
            'text_seo' => 'Текст сео блок',
            'text_seo_val' => 'Текст сео блок',
            'text_spoiler' => 'Текст сео блок под спойлером',
            'text_spoiler_val' => 'Текст сео блок под спойлером',
            'filials' => 'Клиники',
            'filials_input' => 'Клиники',
            'intro_text' => 'Вводный текст',
            'intro_text_val' => 'Вводный текст',
            'intro_image' => 'Вводное изображение',
            'intro_image_input' => 'Вводное изображение',
            'discount_title' => 'Название скидки',
            'discount_title_val' => 'Название скидки',
            'discount_price' => 'Сумма по скидке',
            'discount_price_old' => 'Старая сумма по скидке',
            'discount_button' => 'Кнопка скидки',
            'discount_button_val' => 'Кнопка скидки',
            'price' => 'Стоимость',
            'price_from' => 'Стоимость от',
            'lvl' => 'Уровень вложенности',
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
            'handle_tree' => 'Полный алиас',
            'handle_tree_val' => 'Полный алиас',
        ]);
    }



    public function getLinks() {
        return $this->hasMany(\app\models\ServiceLink::class, ['service_id' => 'id']);
    }
    public function getLinks_real() {
        $res = $this->getLinks()->ordered()->published()->all();
        $this->populateRelation('links_real', $res);

        return $res;
    }
    public function getPrices() {
        return $this->hasMany(\app\models\ServicePrice::class, ['service_id' => 'id']);
    }
    public function getPrices_real() {
        $res = $this->getPrices()->ordered()->published()->all();
        $this->populateRelation('prices_real', $res);

        return $res;
    }
    public function getImages() {
        return $this->hasMany(\app\models\ServiceImage::class, ['service_id' => 'id']);
    }
    public function getImages_real() {
        $res = $this->getImages()->ordered()->published()->all();
        $this->populateRelation('images_real', $res);

        return $res;
    }
    public function getVideos() {
        return $this->hasMany(\app\models\ServiceVideo::class, ['service_id' => 'id']);
    }
    public function getVideos_real() {
        $res = $this->getVideos()->ordered()->published()->all();
        $this->populateRelation('videos_real', $res);

        return $res;
    }
    public function getFaqs() {
        return $this->hasMany(\app\models\Faq::class, ['service_id' => 'id']);
    }
    public function getFaqs_real() {
        $res = $this->getFaqs()->ordered()->published()->all();
        $this->populateRelation('faqs_real', $res);

        return $res;
    }
    public function getBlocks() {
        return $this->hasMany(\app\models\ServiceBlock::class, ['service_id' => 'id']);
    }
    public function getBlocks_real() {
        $res = $this->getBlocks()->ordered()->published()->all();
        $this->populateRelation('blocks_real', $res);

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


    public $icon_del = 0;
    public $icon_input = 0;
    public function getIcon_obj() {
        return new Image($this->icon);
    }
    public $image_del = 0;
    public $image_input = 0;
    public function getImage_obj() {
        return new Image($this->image);
    }
    protected static $typeList = false;
    public static function typeList() {
        if (static::$typeList === false) {
            static::$typeList = [
                'adult' => Yii::t('app', 'Врачи и услуги'),
                'child' => Yii::t('app', 'Программы и чекапы'),
            ];
        }
        return static::$typeList;
    }
    public function getType_val() {
        $items = static::typeList();
        if (!empty($items[$this->type])) return $items[$this->type];
        return '';
    }
    private $_tags_input = false;

    public function getTags_input() {
        if ($this->_tags_input === false) {
            $this->_tags_input = ArrayHelper::getColumn($this->tags, 'id');
        }
        return $this->_tags_input;
    }

    public function setTags_input($value) {
        $this->_tags_input = $value;
    }

    public function getTags() {
        return $this->hasMany(\app\models\ServiceTag::class, ['id' => 'tag_id'])->viaTable('service2tag', ['service_id' => 'id']);
    }
    public $image_2_del = 0;
    public $image_2_input = 0;
    public function getImage_2_obj() {
        return new Image($this->image_2);
    }
    public $image_3_del = 0;
    public $image_3_input = 0;
    public function getImage_3_obj() {
        return new Image($this->image_3);
    }
    private $_members_input = false;

    public function getMembers_input() {
        if ($this->_members_input === false) {
            $this->_members_input = ArrayHelper::getColumn($this->members, 'id');
        }
        return $this->_members_input;
    }

    public function setMembers_input($value) {
        $this->_members_input = $value;
    }

    public function getMembers() {
        return $this->hasMany(\app\models\Member::class, ['id' => 'member_id'])->viaTable('service2member', ['server_id' => 'id']);
    }
    private $_related_services_input = false;

    public function getRelated_services_input() {
        if ($this->_related_services_input === false) {
            $this->_related_services_input = ArrayHelper::getColumn($this->related_services, 'id');
        }
        return $this->_related_services_input;
    }

    public function setRelated_services_input($value) {
        $this->_related_services_input = $value;
    }

    public function getRelated_services() {
        return $this->hasMany(\app\models\Service::class, ['id' => 'related_id'])->viaTable('service2related', ['service_id' => 'id']);
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
        return $this->hasMany(\app\models\Filial::class, ['id' => 'filial_id'])->viaTable('service2filial', ['service_id' => 'id']);
    }
    public $intro_image_del = 0;
    public $intro_image_input = 0;
    public function getIntro_image_obj() {
        return new Image($this->intro_image);
    }
    protected static $lvlList = false;
    public static function lvlList() {
        if (static::$lvlList === false) {
            static::$lvlList = [
                1 => Yii::t('app', '1-ый уровень'),
                12 => Yii::t('app', '1-ый уровень (v2)'),
                2 => Yii::t('app', '2-ой уровень'),
                22 => Yii::t('app', '2-ой уровень (v2)'),
                3 => Yii::t('app', '3-ий уровень'),
            ];
        }
        return static::$lvlList;
    }
    public function getLvl_val() {
        $items = static::lvlList();
        if (!empty($items[$this->lvl])) return $items[$this->lvl];
        return '';
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
        $this->_tags_input = false;
        $this->_members_input = false;
        $this->_related_services_input = false;
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
                'tree_attributes' => array (
  'handle_tree' => 'handle',
),
            ],
        ]);
    }

    public static $search_model_class = '\app\models\search\ServiceSearch';
    public static $model_title = 'Услуга';
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
    'icon' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/service/icon',
    ),
    'image' => 
    array (
      'sort' => 32,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/service/image',
    ),
    'type' => 
    array (
      'sort' => 35,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::typeList(),
    ),
    'is_popular' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'tags' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\ServiceTag',
      'link_table' => 'service2tag',
      'link_id1' => 'service_id',
      'link_id2' => 'tag_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'image_2' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/service/image_2',
    ),
    'image_3' => 
    array (
      'sort' => 65,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/service/image_3',
    ),
    'text_title' => 
    array (
      'sort' => 67,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'members_title' => 
    array (
      'sort' => 75,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'members' => 
    array (
      'sort' => 80,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\Member',
      'link_table' => 'service2member',
      'link_id1' => 'server_id',
      'link_id2' => 'member_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'related_services' => 
    array (
      'sort' => 90,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\Service',
      'link_table' => 'service2related',
      'link_id1' => 'service_id',
      'link_id2' => 'related_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'title_seo' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text_seo' => 
    array (
      'sort' => 110,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'text_spoiler' => 
    array (
      'sort' => 120,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'filials' => 
    array (
      'sort' => 130,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\Filial',
      'link_table' => 'service2filial',
      'link_id1' => 'service_id',
      'link_id2' => 'filial_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'intro_text' => 
    array (
      'sort' => 140,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'intro_image' => 
    array (
      'sort' => 150,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/service/intro_image',
    ),
    'discount_title' => 
    array (
      'sort' => 160,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'discount_price' => 
    array (
      'sort' => 170,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'discount_price_old' => 
    array (
      'sort' => 180,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'discount_button' => 
    array (
      'sort' => 190,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'price' => 
    array (
      'sort' => 200,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'price_from' => 
    array (
      'sort' => 210,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'lvl' => 
    array (
      'sort' => 220,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::lvlList(),
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
      'savePath' => '/up/service/og_image',
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
    'handle_tree' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
    0 => 
    array (
      'variable' => 'links',
      'sort' => '10',
      'model_id' => 'service_id',
      'model' => 'app\\models\\ServiceLink',
      'link_delete' => 'on',
    ),
    1 => 
    array (
      'variable' => 'prices',
      'sort' => '20',
      'model_id' => 'service_id',
      'model' => 'app\\models\\ServicePrice',
      'link_delete' => 'on',
    ),
    2 => 
    array (
      'variable' => 'images',
      'sort' => '30',
      'model_id' => 'service_id',
      'model' => 'app\\models\\ServiceImage',
      'link_delete' => 'on',
    ),
    3 => 
    array (
      'variable' => 'videos',
      'sort' => '40',
      'model_id' => 'service_id',
      'model' => 'app\\models\\ServiceVideo',
      'link_delete' => 'on',
    ),
    4 => 
    array (
      'variable' => 'faqs',
      'sort' => '50',
      'model_id' => 'service_id',
      'model' => 'app\\models\\Faq',
      'link_delete' => 'on',
    ),
    5 => 
    array (
      'variable' => 'blocks',
      'sort' => '60',
      'model_id' => 'service_id',
      'model' => 'app\\models\\ServiceBlock',
      'link_delete' => 'on',
    ),
  ),
  'sti' => '1',
  'tree' => '1',
);

        if (!empty($options['children'])) {
            foreach ($options['children'] as $chKey => $chVal) {
                $options['children'][$chKey]['model'] = $chVal['model'];
            }
        }

        return ArrayHelper::merge(parent::getOptions($model), $options);
    }
}