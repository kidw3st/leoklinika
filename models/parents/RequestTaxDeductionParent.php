<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\components\base\Date;
use app\models\Page;
use app\components\base\Image;
use app\models\SystemNoticeEvent;;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "request_tax_deduction".
 *
 * @property integer $id
 * @property array $options
 * @property string $patient
 * @property string $patient_val
 * @property string $name
 * @property string $relation
 * @property string $birthday
 * @property Date $birthday_obj
 * @property string $inn
 * @property string $card_number
 * @property string $year
 * @property string $passport
 * @property string $passport_date
 * @property Date $passport_date_obj
 * @property string $patient_name
 * @property string $patient_inn
 * @property string $patient_birthday
 * @property Date $patient_birthday_obj
 * @property string $patient_passport
 * @property string $patient_passport_date
 * @property Date $patient_passport_date_obj
 * @property string $email
 * @property string $phone
 * @property string $delivery_method
 * @property string $delivery_method_val
 * @property integer $page_id
 * @property Page $page
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
class RequestTaxDeductionParent extends CActiveRecord {
    public static function tableName()
    {
        return 'request_tax_deduction';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['patient', 'delivery_method'], 'string', 'max' => 50, 'on' => ['default', 'admin']],
            [['name', 'relation', 'inn', 'card_number', 'year', 'passport', 'patient_name', 'patient_inn', 'patient_passport', 'phone', 'seo_title', 'seo_keywords', 'og_title', 'og_image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['birthday_input', 'passport_date_input', 'patient_birthday_input', 'patient_passport_date_input'], 'date', 'format' => 'php:d.m.Y', 'on' => ['default', 'admin']],
            [['email'], 'string', 'max' => 80, 'on' => ['default', 'admin']],
            [['email'], 'email', 'on' => ['default', 'admin']],
            [['page_id'], 'integer', 'on' => ['default', 'admin']],
            [['seo_description', 'og_description'], 'string', 'max' => 500, 'on' => ['default', 'admin']],
            [['og_image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'jpg, png', 'on' => ['default', 'admin']],
            [['og_image_del'], 'boolean', 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['patient', 'delivery_method'], 'string', 'max' => 50, 'on' => 'search'],
            [['name', 'relation', 'birthday', 'inn', 'card_number', 'year', 'passport', 'passport_date', 'patient_name', 'patient_inn', 'patient_birthday', 'patient_passport', 'patient_passport_date', 'email', 'phone', 'page_id', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'patient' => 'Тип',
            'name' => 'Имя',
            'name_val' => 'Имя',
            'relation' => 'Родственная связь',
            'relation_val' => 'Родственная связь',
            'birthday' => 'День рождения',
            'inn' => 'Инн',
            'inn_val' => 'Инн',
            'card_number' => 'Номер амбулаторной карты',
            'card_number_val' => 'Номер амбулаторной карты',
            'year' => 'Год',
            'year_val' => 'Год',
            'passport' => 'Серия и номер паспорта',
            'passport_val' => 'Серия и номер паспорта',
            'passport_date' => 'Дата выдачи паспорта',
            'patient_name' => 'ФИО пациента',
            'patient_name_val' => 'ФИО пациента',
            'patient_inn' => 'ИНН пациента',
            'patient_inn_val' => 'ИНН пациента',
            'patient_birthday' => 'Дата рождения пациента',
            'patient_passport' => 'Паспорт пациента',
            'patient_passport_val' => 'Паспорт пациента',
            'patient_passport_date' => 'Дата выдачи паспорта пациента',
            'email' => 'Email',
            'phone' => 'Телефон',
            'phone_val' => 'Телефон',
            'delivery_method' => 'Способ получения',
            'page_id' => 'Страница',
            'page' => 'Страница',
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


    public function getPage() {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            SystemNoticeEvent::doEvent('request_tax_deduction_created', [
                'item' => $this,
            ], 'Новая запись в таблице "Запрос на налоговый вычет"');
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


    protected static $patientList = false;
    public static function patientList() {
        if (static::$patientList === false) {
            static::$patientList = [
                '1' => Yii::t('app', 'Пациент является плательщиком'),
                '0' => Yii::t('app', 'Пациент не является плательщиком'),
            ];
        }
        return static::$patientList;
    }
    public function getPatient_val() {
        $items = static::patientList();
        if (!empty($items[$this->patient])) return $items[$this->patient];
        return '';
    }
    public function getBirthday_input() {
        if (empty($this->birthday)) return '';

        return date('d.m.Y', strtotime($this->birthday));
    }
    public function setBirthday_input($value) {
        if (empty($value)) {
            $this->birthday = '';
        } else {
            $this->birthday = date('Y-m-d', strtotime($value));
        }
    }
    public function getBirthday_obj() {
        return new Date($this->birthday);
    }
    public function getPassport_date_input() {
        if (empty($this->passport_date)) return '';

        return date('d.m.Y', strtotime($this->passport_date));
    }
    public function setPassport_date_input($value) {
        if (empty($value)) {
            $this->passport_date = '';
        } else {
            $this->passport_date = date('Y-m-d', strtotime($value));
        }
    }
    public function getPassport_date_obj() {
        return new Date($this->passport_date);
    }
    public function getPatient_birthday_input() {
        if (empty($this->patient_birthday)) return '';

        return date('d.m.Y', strtotime($this->patient_birthday));
    }
    public function setPatient_birthday_input($value) {
        if (empty($value)) {
            $this->patient_birthday = '';
        } else {
            $this->patient_birthday = date('Y-m-d', strtotime($value));
        }
    }
    public function getPatient_birthday_obj() {
        return new Date($this->patient_birthday);
    }
    public function getPatient_passport_date_input() {
        if (empty($this->patient_passport_date)) return '';

        return date('d.m.Y', strtotime($this->patient_passport_date));
    }
    public function setPatient_passport_date_input($value) {
        if (empty($value)) {
            $this->patient_passport_date = '';
        } else {
            $this->patient_passport_date = date('Y-m-d', strtotime($value));
        }
    }
    public function getPatient_passport_date_obj() {
        return new Date($this->patient_passport_date);
    }
    protected static $delivery_methodList = false;
    public static function delivery_methodList() {
        if (static::$delivery_methodList === false) {
            static::$delivery_methodList = [
                'in_person' => Yii::t('app', 'Лично (при предъявлении паспорта)'),
                'email' => Yii::t('app', 'По электронной почте'),
            ];
        }
        return static::$delivery_methodList;
    }
    public function getDelivery_method_val() {
        $items = static::delivery_methodList();
        if (!empty($items[$this->delivery_method])) return $items[$this->delivery_method];
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

    public static $search_model_class = '\app\models\search\RequestTaxDeductionSearch';
    public static $model_title = 'Запрос на налоговый вычет';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'patient' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::patientList(),
    ),
    'name' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'relation' => 
    array (
      'sort' => 22,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'birthday' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'date',
    ),
    'inn' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'card_number' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'year' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'passport' => 
    array (
      'sort' => 62,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'passport_date' => 
    array (
      'sort' => 64,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'date',
    ),
    'patient_name' => 
    array (
      'sort' => 65,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'patient_inn' => 
    array (
      'sort' => 66,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'patient_birthday' => 
    array (
      'sort' => 67,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'date',
    ),
    'patient_passport' => 
    array (
      'sort' => 68,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'patient_passport_date' => 
    array (
      'sort' => 69,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'date',
    ),
    'email' => 
    array (
      'sort' => 70,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'email',
    ),
    'phone' => 
    array (
      'sort' => 80,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'delivery_method' => 
    array (
      'sort' => 85,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::delivery_methodList(),
    ),
    'page_id' => 
    array (
      'sort' => 90,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Page',
      'list_template' => 'title',
      'linki1Variable' => 'page',
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
      'savePath' => '/up/requesttaxdeduction/og_image',
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