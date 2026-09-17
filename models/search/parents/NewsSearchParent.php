<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "news".
 *
 * @property string $title
 * @property string $handle
 * @property string $image
 * @property string $date
 * @property string $text
 * @property integer $public
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $og_title
 * @property string $og_description
 * @property string $og_image
 * @property string $created_at
 * @property string $updated_at
 */
class NewsSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\News';

    public $title;
    public $handle;
    public $image;
    public $date;
    public $text;
    public $public;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $og_title;
    public $og_description;
    public $og_image;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'handle', 'date', 'text', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string'],
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
        if ($attribute == 'handle') return $this->filter_string($attribute);
        if ($attribute == 'date') return $this->filter_date($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'public') return $this->filter_checkbox($attribute);
        if ($attribute == 'seo_title') return $this->filter_string($attribute);
        if ($attribute == 'seo_description') return $this->filter_string($attribute);
        if ($attribute == 'seo_keywords') return $this->filter_string($attribute);
        if ($attribute == 'og_title') return $this->filter_string($attribute);
        if ($attribute == 'og_description') return $this->filter_string($attribute);
        if ($attribute == 'created_at') return $this->filter_date($attribute);
        if ($attribute == 'updated_at') return $this->filter_date($attribute);
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
    public function search_field_handle($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'handle', $parent_atttribute);
    }
    public function search_field_date($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'date', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
    public function search_field_seo_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'seo_title', $parent_atttribute);
    }
    public function search_field_seo_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'seo_description', $parent_atttribute);
    }
    public function search_field_seo_keywords($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'seo_keywords', $parent_atttribute);
    }
    public function search_field_og_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'og_title', $parent_atttribute);
    }
    public function search_field_og_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'og_description', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
}