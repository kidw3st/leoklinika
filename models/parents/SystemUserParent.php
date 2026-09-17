<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\TimesBehavior;
use app\components\base\Image;
use app\models\SystemUserGroup;
use app\components\base\Date;
use app\components\base\CActiveRecord;
use app\models\SystemUserSocial;
use app\models\SystemUserConfirm;
/**
 * This is the model class for table "system_user".
 *
 * @property integer $id
 * @property array $options
 * @property string $login_username
 * @property string $login_email
 * @property integer $login_phone_input
 * @property string $password
 * @property string $password_input
 * @property string $auth_key
 * @property string $name
 * @property string $surname
 * @property string $second_name
 * @property string $access_token
 * @property string $image
 * @property Image $image_obj
 * @property float $status
 * @property string $status_val
 * @property array $cookieArray_obj
 * @property bool $admin
 * @property integer $group_id
 * @property SystemUserGroup $group
 * @property string $created_at
 * @property Date $created_at_obj
 * @property string $updated_at
 * @property Date $updated_at_obj
 * @property SystemUserSocial[] $socs
 * @property SystemUserSocial[] $socs_real
 * @property SystemUserConfirm[] $confirms
 * @property SystemUserConfirm[] $confirms_real
 */
class SystemUserParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_user';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['login_username', 'name', 'surname', 'second_name', 'image'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['login_email'], 'string', 'max' => 80, 'on' => ['default', 'admin']],
            [['login_email'], 'email', 'on' => ['default', 'admin']],
            [['login_phone', 'status'], 'number', 'on' => ['default', 'admin']],
            [['login_phone_input', 'password_input', 'cookieArray'], 'safe', 'on' => ['default', 'admin']],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 32, 'on' => ['default', 'admin']],
            [['image_input'], 'file', 'checkExtensionByMimeType' => false, 'extensions' => 'png,jpg,jpeg,svg', 'on' => ['default', 'admin']],
            [['image_del', 'admin'], 'boolean', 'on' => ['default', 'admin']],
            [['group_id'], 'integer', 'on' => ['default', 'admin']],
            [['created_at_input', 'updated_at_input'], 'date', 'format' => 'php:d.m.Y H:i:s', 'on' => ['default', 'admin']],

            [['login_username', 'login_email', 'auth_key', 'name', 'surname', 'second_name', 'access_token', 'group_id', 'created_at', 'updated_at'], 'string', 'on' => 'search'],
            [['login_phone', 'status'], 'number', 'on' => 'search'],
            [['admin'], 'boolean', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'login_username' => 'Никнейм',
            'login_username_val' => 'Никнейм',
            'login_email' => 'E-mail',
            'login_phone' => 'Телефон',
            'login_phone_input' => 'Телефон',
            'password' => 'Пароль',
            'password_input' => 'Пароль',
            'auth_key' => 'Ключ',
            'auth_key_val' => 'Ключ',
            'name' => 'Имя',
            'name_val' => 'Имя',
            'surname' => 'Фамилия',
            'surname_val' => 'Фамилия',
            'second_name' => 'Отчество',
            'second_name_val' => 'Отчество',
            'access_token' => 'Токен',
            'access_token_val' => 'Токен',
            'image' => 'Фото',
            'image_input' => 'Фото',
            'status' => 'Статус',
            'cookieArray' => 'Куки',
            'cookieArray_obj' => 'Куки',
            'admin' => 'Доступ в админку',
            'group_id' => 'Группа',
            'group' => 'Группа',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ]);
    }


    public function getGroup() {
        return $this->hasOne(SystemUserGroup::class, ['id' => 'group_id']);
    }

    public function getSocs() {
        return $this->hasMany(\app\models\SystemUserSocial::class, ['user_id' => 'id']);
    }
    public function getSocs_real() {
        $res = $this->getSocs()->all();
        $this->populateRelation('socs_real', $res);

        return $res;
    }
    public function getConfirms() {
        return $this->hasMany(\app\models\SystemUserConfirm::class, ['user_id' => 'id']);
    }
    public function getConfirms_real() {
        $res = $this->getConfirms()->all();
        $this->populateRelation('confirms_real', $res);

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


    public function getLogin_phone_input() {
        return static::phoneFormat($this->login_phone);
    }
    public function setLogin_phone_input($value) {
        $this->login_phone = preg_replace('/[^0-9]/', '', $value);
    }
    public function getPassword_input() {
        return '';
    }
    public function setPassword_input($value) {
        if (!empty($value)) $this->password = static::generatePassword($value);
    }
    public $image_del = 0;
    public $image_input = 0;
    public function getImage_obj() {
        return new Image($this->image);
    }
    protected static $statusList = false;
    public static function statusList() {
        if (static::$statusList === false) {
            static::$statusList = [
                0 => Yii::t('app', 'Регистрация не завершена'),
                1 => Yii::t('app', 'Не активен'),
                2 => Yii::t('app', 'Активен'),
            ];
        }
        return static::$statusList;
    }
    public function getStatus_val() {
        $items = static::statusList();
        if (!empty($items[$this->status])) return $items[$this->status];
        return '';
    }
    public function getCookieArray_obj() {
        return json_decode($this->cookieArray, true);
    }
    public function setCookieArray_obj(array $value) {
        $this->cookieArray = json_encode($value);
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

    public static $search_model_class = '\app\models\search\SystemUserSearch';
    public static $model_title = 'Пользователь';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'login_username' => 
    array (
      'sort' => 10,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'login_email' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'email',
    ),
    'login_phone' => 
    array (
      'sort' => 30,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'phone',
    ),
    'password' => 
    array (
      'sort' => 40,
      'edited' => true,
      'inserted' => true,
      'type' => 'password',
    ),
    'auth_key' => 
    array (
      'sort' => 60,
      'type' => 'string',
      'editor' => 'input',
    ),
    'name' => 
    array (
      'sort' => 70,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'surname' => 
    array (
      'sort' => 80,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'second_name' => 
    array (
      'sort' => 90,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'access_token' => 
    array (
      'sort' => 100,
      'type' => 'string',
      'editor' => 'input',
    ),
    'image' => 
    array (
      'sort' => 200,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'file',
      'isImage' => 'on',
      'savePath' => '/up/systemuser/image',
    ),
    'status' => 
    array (
      'sort' => 210,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'select',
      'items' => static::statusList(),
    ),
    'cookieArray' => 
    array (
      'sort' => 240,
      'type' => 'json',
    ),
    'admin' => 
    array (
      'sort' => 270,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'group_id' => 
    array (
      'sort' => 320,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemUserGroup',
      'list_template' => 'title',
      'linki1Variable' => 'group',
    ),
    'created_at' => 
    array (
      'sort' => 100010,
      'viewed' => true,
      'type' => 'datetime',
    ),
    'updated_at' => 
    array (
      'sort' => 100010,
      'type' => 'datetime',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
    0 => 
    array (
      'variable' => 'socs',
      'sort' => '10',
      'model_id' => 'user_id',
      'model' => 'app\\models\\SystemUserSocial',
      'link_delete' => 'on',
    ),
    1 => 
    array (
      'variable' => 'confirms',
      'sort' => '20',
      'model_id' => 'user_id',
      'model' => 'app\\models\\SystemUserConfirm',
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