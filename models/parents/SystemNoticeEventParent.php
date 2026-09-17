<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\base\HandleBehavior;
use app\components\base\CActiveRecord;
use app\models\SystemNoticeTemplateEmail;
/**
 * This is the model class for table "system_notice_event".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $handle
 * @property array $variables_obj
 * @property bool $public
 * @property SystemNoticeTemplateEmail[] $templates_email
 * @property SystemNoticeTemplateEmail[] $templates_email_real
 */
class SystemNoticeEventParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_notice_event';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'handle'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['variables'], 'safe', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'handle'], 'string', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'handle' => 'Алиас',
            'variables' => 'Переменные',
            'variables_obj' => 'Переменные',
            'public' => 'Публикация',
        ]);
    }



    public function getTemplates_email() {
        return $this->hasMany(\app\models\SystemNoticeTemplateEmail::class, ['event_id' => 'id']);
    }
    public function getTemplates_email_real() {
        $res = $this->getTemplates_email()->published()->all();
        $this->populateRelation('templates_email_real', $res);

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


    public function getVariables_obj() {
        return json_decode($this->variables, true);
    }
    public function setVariables_obj(array $value) {
        $this->variables = json_encode($value);
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

    public static $search_model_class = '\app\models\search\SystemNoticeEventSearch';
    public static $model_title = 'Событие уведомления';
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
    'variables' => 
    array (
      'sort' => 30,
      'type' => 'json',
    ),
    'public' => 
    array (
      'sort' => 100030,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
    0 => 
    array (
      'variable' => 'templates_email',
      'sort' => '10',
      'model_id' => 'event_id',
      'model' => 'app\\models\\SystemNoticeTemplateEmail',
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