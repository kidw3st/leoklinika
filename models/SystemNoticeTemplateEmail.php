<?php
namespace app\models;

use Yii;
use app\models\parents\SystemNoticeTemplateEmailParent;
use yii\helpers\ArrayHelper;

class SystemNoticeTemplateEmail extends SystemNoticeTemplateEmailParent
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

        $res['fields']['info'] = [
            'sort' => 100000,
            'edited' => true,
            'inserted' => true,
            'type' => 'info',
        ];

        return $res;
    }

    public function doTemplate($fields)
    {
        $fields['site'] = [
            'title' => SystemSettings::getParam('adminbase', 'site_name', 'Сайт'),
            'email' => SystemSettings::getParam('adminbase', 'site_email', 'testnotification99@gmail.com'),
            'phone' => SystemSettings::getParam('adminbase', 'site_phone', '+7 (123) 456-78-90'),
            'url'   => SystemSettings::getParam('adminbase', 'site_url', 'http://localhost'),
        ];

        $mailer = Yii::$app->mailer->compose()
            ->setHtmlBody($this->doReplace($this->text, $fields))
            ->setFrom($this->doReplace($this->email_from, $fields))
            ->setSubject($this->doReplace($this->subject, $fields));

        $email_to = $this->doReplace($this->email_to, $fields);
        $email_bcc = $this->doReplace($this->email_bcc, $fields);

        if ($email_bcc != '') $mailer->setBcc(preg_split('/\s*,\s*/', $email_bcc));
        if ($email_to != '') $mailer->setTo(preg_split('/\s*,\s*/', $email_to))->send();
    }

    public function doReplace($text, $fields) {
        $replacements = [];
        preg_match_all('/\[\[([-\_\.a-zA-Z0-9]+)\]\]/', $text, $m);
        if (!empty($m[1])) {
            foreach($m[1] as $param) {
                if (empty($replacements['[[' . $param . ']]']))
                    $replacements['[[' . $param . ']]'] = ArrayHelper::getValue($fields, $param);
            }
        }

        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }

    public function getInfo() {
        $vars = [
            'Общие' => [
                '[[site.title]]' => 'Наименование сайта',
                '[[site.email]]' => 'Email сайта',
                '[[site.phone]]' => 'Телефон сайта',
                '[[site.url]]' => 'Адрес сайта (Для ссылок)',
            ],
        ];

        if (!empty($this->event->variables)) {
            foreach ($this->event->variables_obj as $k => $className) {
                $options = $className::getOptions();

                $vars[$options['label']] = $className::getEventVariables($k);
            }
        }

        return $this->infoRecursive($vars);
    }

    private function infoRecursive($vars) {
        $res = '<ul>';
        foreach ($vars as $k => $var) {
            $res .= '<li>';
            if (is_array($var)) {
                $res .= $k . $this->infoRecursive($var);
            } else {
                $res .= '<span class="insertInFocus">' . $k . '</span> — ' . $var;
            }
            $res .= '</li>';
        }
        $res .= '</ul>';
        return $res;
    }
}