<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Service;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "service_price".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property float $price
 * @property bool $price_from
 * @property bool $is_consult
 * @property integer $service_id
 * @property Service $service
 * @property bool $public
 * @property integer $weight
 */
class ServicePriceParent extends CActiveRecord {
    public static function tableName()
    {
        return 'service_price';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['price'], 'number', 'on' => ['default', 'admin']],
            [['price_from', 'is_consult'], 'boolean', 'on' => ['default', 'admin']],
            [['actions_input'], 'safe', 'on' => ['default', 'admin']],
            [['service_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'service_id'], 'string', 'on' => 'search'],
            [['price'], 'number', 'on' => 'search'],
            [['price_from', 'is_consult', 'public'], 'boolean', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'price' => 'Стоимость',
            'price_from' => 'От?',
            'is_consult' => 'Консультационная услуга',
            'actions' => 'Акции',
            'actions_input' => 'Акции',
            'service_id' => 'Услуга',
            'service' => 'Услуга',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getService() {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
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


    private $_actions_input = false;

    public function getActions_input() {
        if ($this->_actions_input === false) {
            $this->_actions_input = ArrayHelper::getColumn($this->actions, 'id');
        }
        return $this->_actions_input;
    }

    public function setActions_input($value) {
        $this->_actions_input = $value;
    }

    public function getActions() {
        return $this->hasMany(\app\models\Action::class, ['id' => 'action_id'])->viaTable('action2price', ['price_id' => 'id']);
    }

    public function variables_refresh()
    {
        $this->_actions_input = false;
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\ServicePriceSearch';
    public static $model_title = 'Цена';
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
    'price' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'price_from' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'is_consult' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'actions' => 
    array (
      'sort' => 50,
      'locale' => 0,
      'edited' => true,
      'inserted' => true,
      'type' => 'link_IToI',
      'linkiiParent' => 'app\\models\\Action',
      'link_table' => 'action2price',
      'link_id1' => 'price_id',
      'link_id2' => 'action_id',
      'list_template' => 'title',
      'link_ajax' => false,
    ),
    'service_id' => 
    array (
      'sort' => 60,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Service',
      'list_template' => 'title',
      'linki1Variable' => 'service',
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