<?php
namespace app\models;

use Yii;
use app\models\parents\SystemNoticeEventParent;

class SystemNoticeEvent extends SystemNoticeEventParent
{
    public $set_update_time = false;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
        
        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    public static function doEvent($event_handle, $fields, $default_title = false) {
        $variables = [];
        foreach ($fields as $k => $field) {
            if (is_object($field)) {
                $variables[$k] = get_class($field);
            }
        }

        /**
         * @var SystemNoticeEvent $event
         * @var SystemNoticeTemplateEmail $template_email
         */
        $event = static::find()->where(['handle' => $event_handle])->one();
        if (!$event) {
            $event = new static();
            $event->title = $default_title?$default_title:$event_handle;
            $event->handle = $event_handle;
            $event->save();
        }

        if (empty($event->variables)) {
            $event->variables = json_encode($variables);
            $event->save();
        }

        if ($event->public > 0) {
            if (!empty($event->templates_email_real)) {
                foreach ($event->templates_email_real as $template_email) {
                    $template_email->doTemplate($fields);
                }
            }

            if (!empty($event->templates_sms_real)) {
                foreach ($event->templates_sms_real as $template_sms) {
                    $template_sms->doTemplate($fields);
                }
            }
        }
    }
}