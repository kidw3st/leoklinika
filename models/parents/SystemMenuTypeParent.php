<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\HandleBehavior;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "system_menu_type".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $handle
 */
class SystemMenuTypeParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_menu_type';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'handle'], 'string', 'max' => 255, 'on' => ['default', 'admin']],

            [['title', 'handle'], 'string', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'handle' => 'Алиас',
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



    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'handleBehavior' => [
                'class' => HandleBehavior::className(),
                'attributes' => array (
  'handle' => 'title',
),
            ],
        ]);
    }

    public static $search_model_class = '\app\models\search\SystemMenuTypeSearch';
    public static $model_title = 'Тип меню';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'title' => 
    array (
      'sort' => 10,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'handle' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'handle',
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