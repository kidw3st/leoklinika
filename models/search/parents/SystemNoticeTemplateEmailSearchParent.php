<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_notice_template_email".
 *
 * @property string $title
 * @property string $subject
 * @property string $email_from
 * @property string $email_to
 * @property string $email_bcc
 * @property string $text
 * @property string $event_id
 * @property integer $public
 */
class SystemNoticeTemplateEmailSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemNoticeTemplateEmail';

    public $title;
    public $subject;
    public $email_from;
    public $email_to;
    public $email_bcc;
    public $text;
    public $event_id;
    public $public;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'subject', 'email_from', 'email_to', 'email_bcc', 'text', 'event_id'], 'string'],
            [['public'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'title') return $this->filter_string($attribute);
        if ($attribute == 'subject') return $this->filter_string($attribute);
        if ($attribute == 'email_from') return $this->filter_string($attribute);
        if ($attribute == 'email_to') return $this->filter_string($attribute);
        if ($attribute == 'email_bcc') return $this->filter_string($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'event_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'public') return $this->filter_checkbox($attribute);
        return parent::field_filter_input($attribute);
    }

    public function search($query, $dataProviderParams, $params)
    {
        $dataProvider = new ActiveDataProvider(array_merge([
            'query' => $query,
        ], $dataProviderParams));

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        foreach ($this->attributes as $attribute => $value) {
            $method = 'search_field_'.$attribute;
            if (!empty($value) && method_exists($this, $method)) {
                $this->{$method}($query);
            }
        }

        return $dataProvider;
    }

    public function search_field_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title', $parent_atttribute);
    }
    public function search_field_subject($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'subject', $parent_atttribute);
    }
    public function search_field_email_from($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'email_from', $parent_atttribute);
    }
    public function search_field_email_to($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'email_to', $parent_atttribute);
    }
    public function search_field_email_bcc($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'email_bcc', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_event_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'event_id', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}