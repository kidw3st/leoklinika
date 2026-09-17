<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Member;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "member_expirience".
 *
 * @property integer $id
 * @property array $options
 * @property integer $from
 * @property integer $to
 * @property string $text
 * @property integer $member_id
 * @property Member $member
 * @property bool $public
 */
class MemberExpirienceParent extends CActiveRecord {
    public static function tableName()
    {
        return 'member_expirience';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['from'], 'required', 'on' => ['default', 'admin']],
            [['from', 'to', 'member_id'], 'integer', 'on' => ['default', 'admin']],
            [['text'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['from', 'to'], 'integer', 'on' => 'search'],
            [['text', 'member_id'], 'string', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'from' => 'От',
            'to' => 'До',
            'text' => 'Деятельность',
            'text_val' => 'Деятельность',
            'member_id' => 'Сотрудник',
            'member' => 'Сотрудник',
            'public' => 'Публикация',
        ]);
    }


    public function getMember() {
        return $this->hasOne(Member::class, ['id' => 'member_id']);
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
        ]);
    }

    public static $search_model_class = '\app\models\search\MemberExpirienceSearch';
    public static $model_title = 'Опыт';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'from' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'to' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
    'text' => 
    array (
      'sort' => 30,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'member_id' => 
    array (
      'sort' => 40,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\Member',
      'list_template' => 'title',
      'linki1Variable' => 'member',
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