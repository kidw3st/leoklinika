<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "form_setting".
 *
 * @property string $form_name
 * @property string $form_type
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $link_title
 * @property string $video_id
 * @property string $success_text
 */
class FormSettingSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\FormSetting';

    public $form_name;
    public $form_type;
    public $title;
    public $description;
    public $image;
    public $link_title;
    public $video_id;
    public $success_text;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['form_name', 'form_type', 'title', 'description', 'link_title', 'video_id', 'success_text'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'form_name') return $this->filter_string($attribute);
        if ($attribute == 'form_type') return $this->filter_string($attribute);
        if ($attribute == 'title') return $this->filter_string($attribute);
        if ($attribute == 'description') return $this->filter_string($attribute);
        if ($attribute == 'link_title') return $this->filter_string($attribute);
        if ($attribute == 'video_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'success_text') return $this->filter_string($attribute);
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

    public function search_field_form_name($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'form_name', $parent_atttribute);
    }
    public function search_field_form_type($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'form_type', $parent_atttribute);
    }
    public function search_field_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title', $parent_atttribute);
    }
    public function search_field_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'description', $parent_atttribute);
    }
    public function search_field_link_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link_title', $parent_atttribute);
    }
    public function search_field_video_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'video_id', $parent_atttribute);
    }
    public function search_field_success_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'success_text', $parent_atttribute);
    }
}