<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\Image;
use app\models\Video;
use app\models\Page;
use app\components\base\CActiveRecord;
use app\models\PageBlockSlide;
use app\models\PageBlockAdvantage;
use app\models\PageBlockNumber;
use app\models\PageBlockMission;
use app\models\PageBlockButton;
use app\models\PageBlockImage;
use app\models\PageBlockLink;
/**
 * This is the model class for table "page_block".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $title_2
 * @property bool $show_title
 * @property string $block_type
 * @property string $block_type_val
 * @property string $description
 * @property string $info
 * @property string $text
 * @property string $image
 * @property Image $image_obj
 * @property string $image_mobile
 * @property Image $image_mobile_obj
 * @property string $form_type
 * @property string $form_type_val
 * @property string $link
 * @property string $link_title
 * @property bool $only_popular
 * @property bool $only_lead
 * @property string $video_title
 * @property integer $video_id
 * @property Video $video
 * @property string $success_text
 * @property integer $page_id
 * @property Page $page
 * @property bool $public
 * @property integer $weight
 * @property PageBlockSlide[] $slides
 * @property PageBlockSlide[] $slides_real
 * @property PageBlockAdvantage[] $advantages
 * @property PageBlockAdvantage[] $advantages_real
 * @property PageBlockNumber[] $numbers
 * @property PageBlockNumber[] $numbers_real
 * @property PageBlockMission[] $missions
 * @property PageBlockMission[] $missions_real
 * @property PageBlockButton[] $buttons
 * @property PageBlockButton[] $buttons_real
 * @property PageBlockImage[] $images
 * @property PageBlockImage[] $images_real
 * @property PageBlockLink[] $links
 * @property PageBlockLink[] $links_real
 */
class PageBlockParent extends CActiveRecord {
    public static function tableName()
    {
        return 'page_block';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'title_2', 'info', 'image', 'image_mobile', 'link', 'link_title', 'video_title', 'success_text'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['show_title', 'image_del', 'image_mobile_del', 'only_popular', 'only_lead'], 'boolean', 'on' => ['default', 'admin']],
            [['block_type', 'form_type'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['description', 'text'], 'string', 'on' => ['default', 'admin']],
            [['image_input', 'image_mobile_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['video_id', 'page_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'title_2', 'description', 'info', 'text', 'link', 'link_title', 'video_title', 'video_id', 'success_text', 'page_id'], 'string', 'on' => 'search'],
            [['show_title', 'only_popular', 'only_lead', 'public'], 'boolean', 'on' => 'search'],
            [['block_type', 'form_type'], 'string', 'max' => 50, 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'title_2' => 'Второй заголовок',
            'title_2_val' => 'Второй заголовок',
            'show_title' => 'Показать заголовок?',
            'block_type' => 'Тип блока',
            'description' => 'Описание',
            'description_val' => 'Описание',
            'info' => 'Текст в кружке',
            'info_val' => 'Текст в кружке',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'image' => 'Изображение',
            'image_input' => 'Изображение',
            'image_mobile' => 'Изображение адаптив',
            'image_mobile_input' => 'Изображение адаптив',
            'form_type' => 'Форма',
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'link_title' => 'Текст ссылки',
            'link_title_val' => 'Текст ссылки',
            'only_popular' => 'Только популярные',
            'only_lead' => 'Только ведущие',
            'video_title' => 'Кнопка видео',
            'video_title_val' => 'Кнопка видео',
            'video_id' => 'Видео',
            'video' => 'Видео',
            'success_text' => 'Текст успеха',
            'success_text_val' => 'Текст успеха',
            'page_id' => 'Страница',
            'page' => 'Страница',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getVideo() {
        return $this->hasOne(Video::class, ['id' => 'video_id']);
    }
    public function getPage() {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }

    public function getSlides() {
        return $this->hasMany(\app\models\PageBlockSlide::class, ['page_block_id' => 'id']);
    }
    public function getSlides_real() {
        $res = $this->getSlides()->ordered()->published()->all();
        $this->populateRelation('slides_real', $res);

        return $res;
    }
    public function getAdvantages() {
        return $this->hasMany(\app\models\PageBlockAdvantage::class, ['page_block_id' => 'id']);
    }
    public function getAdvantages_real() {
        $res = $this->getAdvantages()->ordered()->published()->all();
        $this->populateRelation('advantages_real', $res);

        return $res;
    }
    public function getNumbers() {
        return $this->hasMany(\app\models\PageBlockNumber::class, ['page_block_id' => 'id']);
    }
    public function getNumbers_real() {
        $res = $this->getNumbers()->ordered()->published()->all();
        $this->populateRelation('numbers_real', $res);

        return $res;
    }
    public function getMissions() {
        return $this->hasMany(\app\models\PageBlockMission::class, ['page_block_id' => 'id']);
    }
    public function getMissions_real() {
        $res = $this->getMissions()->ordered()->published()->all();
        $this->populateRelation('missions_real', $res);

        return $res;
    }
    public function getButtons() {
        return $this->hasMany(\app\models\PageBlockButton::class, ['page_block_id' => 'id']);
    }
    public function getButtons_real() {
        $res = $this->getButtons()->ordered()->published()->all();
        $this->populateRelation('buttons_real', $res);

        return $res;
    }
    public function getImages() {
        return $this->hasMany(\app\models\PageBlockImage::class, ['page_block_id' => 'id']);
    }
    public function getImages_real() {
        $res = $this->getImages()->ordered()->published()->all();
        $this->populateRelation('images_real', $res);

        return $res;
    }
    public function getLinks() {
        return $this->hasMany(\app\models\PageBlockLink::class, ['page_block_id' => 'id']);
    }
    public function getLinks_real() {
        $res = $this->getLinks()->ordered()->published()->all();
        $this->populateRelation('links_real', $res);

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


    protected static $block_typeList = false;
    public static function block_typeList() {
        if (static::$block_typeList === false) {
            static::$block_typeList = [
                'text' => Yii::t('app', 'Текст'),
                'text_2' => Yii::t('app', 'Текст'),
                'slider' => Yii::t('app', 'Слайдер'),
                'services' => Yii::t('app', 'Услуги'),
                'actions' => Yii::t('app', 'Акции'),
                'members' => Yii::t('app', 'Сотрудники'),
                'advantages' => Yii::t('app', 'Достижения'),
                'missions' => Yii::t('app', 'Цели'),
                'numbers' => Yii::t('app', 'Показатели'),
                'buttons' => Yii::t('app', 'Кнопки'),
                'links' => Yii::t('app', 'Ссылки'),
                'gallery' => Yii::t('app', 'Галерея'),
                'gallery_2' => Yii::t('app', 'Сертификаты'),
                'form' => Yii::t('app', 'Форма'),
                'reviews' => Yii::t('app', 'Отзывы'),
                'banner' => Yii::t('app', 'Баннер'),
                'banner_2' => Yii::t('app', 'Баннер (Простой)'),
                'action' => Yii::t('app', 'Акция'),
                'news' => Yii::t('app', 'Новости'),
                'articles' => Yii::t('app', 'Статьи'),
                'text_seo' => Yii::t('app', 'Сео блок'),
                'text_image' => Yii::t('app', 'Текст с картинкой на плашке'),
                'text_image_2' => Yii::t('app', 'Текст с картинкой на плашке 2'),
                'text_image_3' => Yii::t('app', 'Текст с картинкой и видео'),
                'text_image_4' => Yii::t('app', 'Текст с картинкой и ссылкой'),
                'faq' => Yii::t('app', 'Вопрос-ответ'),
                'map' => Yii::t('app', 'Карта'),
                'filials' => Yii::t('app', 'Информация по филиалам'),
            ];
        }
        return static::$block_typeList;
    }
    public function getBlock_type_val() {
        $items = static::block_typeList();
        if (!empty($items[$this->block_type])) return $items[$this->block_type];
        return '';
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
    protected static $form_typeList = false;
    public static function form_typeList() {
        if (static::$form_typeList === false) {
            static::$form_typeList = [
                'consult' => Yii::t('app', 'Консультация'),
                'feedback' => Yii::t('app', 'Обратная связь'),
            ];
        }
        return static::$form_typeList;
    }
    public function getForm_type_val() {
        $items = static::form_typeList();
        if (!empty($items[$this->form_type])) return $items[$this->form_type];
        return '';
    }

    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\PageBlockSearch';
    public static $model_title = 'Блок страницы';
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
    'title_2' => 
    array (
      'sort' => 15,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'show_title' => 
    array (
      'sort' => 17,
      'locale' => 0,
      'type' => 'checkbox',
    ),
    'block_type' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::block_typeList(),
    ),
    'description' => 
    array (
      'sort' => 25,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'textarea',
    ),
    'info' => 
    array (
      'sort' => 27,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'image' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/pageblock/image',
    ),
    'image_mobile' => 
    array (
      'sort' => 45,
      'locale' => 0,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/pageblock/image_mobile',
    ),
    'form_type' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'type' => 'select',
      'items' => static::form_typeList(),
    ),
    'link' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'link_title' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'only_popular' => 
    array (
      'sort' => 80,
      'locale' => 0,
      'type' => 'checkbox',
    ),
    'only_lead' => 
    array (
      'sort' => 90,
      'locale' => 0,
      'type' => 'checkbox',
    ),
    'video_title' => 
    array (
      'sort' => 95,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'video_id' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Video',
      'list_template' => 'title',
      'linki1Variable' => 'video',
      'link_ajax' => false,
    ),
    'success_text' => 
    array (
      'sort' => 110,
      'locale' => 0,
      'type' => 'string',
      'editor' => 'input',
    ),
    'page_id' => 
    array (
      'sort' => 1000,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Page',
      'list_template' => 'title',
      'linki1Variable' => 'page',
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
    0 => 
    array (
      'variable' => 'slides',
      'sort' => '10',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockSlide',
      'link_delete' => 'on',
    ),
    1 => 
    array (
      'variable' => 'advantages',
      'sort' => '20',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockAdvantage',
      'link_delete' => 'on',
    ),
    2 => 
    array (
      'variable' => 'numbers',
      'sort' => '30',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockNumber',
      'link_delete' => 'on',
    ),
    3 => 
    array (
      'variable' => 'missions',
      'sort' => '40',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockMission',
      'link_delete' => 'on',
    ),
    4 => 
    array (
      'variable' => 'buttons',
      'sort' => '50',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockButton',
      'link_delete' => 'on',
    ),
    5 => 
    array (
      'variable' => 'images',
      'sort' => '60',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockImage',
      'link_delete' => 'on',
    ),
    6 => 
    array (
      'variable' => 'links',
      'sort' => '70',
      'model_id' => 'page_block_id',
      'model' => 'app\\models\\PageBlockLink',
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