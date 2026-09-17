<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\base\CActiveRecordTree;
/**
 * This is the model class for table "system_menu".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $url
 * @property bool $is_service
 * @property string $title_2
 * @property string $title_3
 * @property bool $public
 */
class SystemMenuParent extends CActiveRecordTree {
    public static function tableName()
    {
        return 'system_menu';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'url', 'title_2', 'title_3'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['types_input'], 'safe', 'on' => ['default', 'admin']],
            [['is_service'], 'boolean', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'url', 'title_2', 'title_3'], 'string', 'on' => 'search'],
            [['is_service', 'public'], 'boolean', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'url' => 'Ссылка',
            'url_val' => 'Ссылка',
            'types' => 'Типы',
            'types_input' => 'Типы',
            'is_service' => 'Услуга?',
            'title_2' => 'Наименование (Посмотреть)',
            'title_2_val' => 'Наименование (Посмотреть)',
            'title_3' => 'Наименование (Ссылка)',
            'title_3_val' => 'Наименование (Ссылка)',
            'public' => 'Публикация',
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


    private $_types_input = false;

    public function getTypes_input() {
        if ($this->_types_input === false) {
            $this->_types_input = ArrayHelper::getColumn($this->types, 'id');
        }
        return $this->_types_input;
    }

    public function setTypes_input($value) {
        $this->_types_input = $value;
    }

    public function getTypes() {
        return $this->hasMany(\app\models\SystemMenuType::class, ['id' => 'type_id'])->viaTable('system_menu2type', ['menu_id' => 'id']);
    }

    public function variables_refresh()
    {
        $this->_types_input = false;
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\SystemMenuSearch';
    public static $model_title = 'Меню';
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
    'url' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'types' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\SystemMenuType',
      'link_table' => 'system_menu2type',
      'link_id1' => 'menu_id',
      'link_id2' => 'type_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'is_service' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'title_2' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'title_3' => 
    array (
      'sort' => 60,
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
  ),
  'label' => static::$model_title,
  'children' => 
  array (
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