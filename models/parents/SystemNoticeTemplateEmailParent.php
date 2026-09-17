<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SystemNoticeEvent;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "system_notice_template_email".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $subject
 * @property string $email_from
 * @property string $email_to
 * @property string $email_bcc
 * @property string $text
 * @property integer $event_id
 * @property SystemNoticeEvent $event
 * @property bool $public
 */
class SystemNoticeTemplateEmailParent extends CActiveRecord {
    public static function tableName()
    {
        return 'system_notice_template_email';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'subject', 'email_from'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['email_to', 'email_bcc'], 'string', 'max' => 1000, 'on' => ['default', 'admin']],
            [['text'], 'string', 'on' => ['default', 'admin']],
            [['event_id'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'subject', 'email_from', 'email_to', 'email_bcc', 'text', 'event_id'], 'string', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'subject' => 'Тема письма',
            'subject_val' => 'Тема письма',
            'email_from' => 'От кого',
            'email_from_val' => 'От кого',
            'email_to' => 'Кому',
            'email_to_val' => 'Кому',
            'email_bcc' => 'Копия',
            'email_bcc_val' => 'Копия',
            'text' => 'Текст',
            'text_val' => 'Текст',
            'event_id' => 'Событие',
            'event' => 'Событие',
            'public' => 'Публикация',
        ]);
    }


    public function getEvent() {
        return $this->hasOne(SystemNoticeEvent::class, ['id' => 'event_id']);
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

    public static $search_model_class = '\app\models\search\SystemNoticeTemplateEmailSearch';
    public static $model_title = 'Email шаблон';
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
    'subject' => 
    array (
      'sort' => 20,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'email_from' => 
    array (
      'sort' => 30,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'email_to' => 
    array (
      'sort' => 40,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'email_bcc' => 
    array (
      'sort' => 50,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'text' => 
    array (
      'sort' => 80,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'redactor',
    ),
    'event_id' => 
    array (
      'sort' => 90,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\SystemNoticeEvent',
      'list_template' => 'title',
      'linki1Variable' => 'event',
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