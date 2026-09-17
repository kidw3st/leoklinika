<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "service".
 *
 * @property string $title
 * @property string $handle
 * @property string $icon
 * @property string $image
 * @property string $type
 * @property integer $is_popular
 * @property string $tags
 * @property string $image_2
 * @property string $image_3
 * @property string $text_title
 * @property string $text
 * @property string $members_title
 * @property string $members
 * @property string $related_services
 * @property string $title_seo
 * @property string $text_seo
 * @property string $text_spoiler
 * @property string $filials
 * @property string $intro_text
 * @property string $intro_image
 * @property string $discount_title
 * @property string $discount_price
 * @property string $discount_price_old
 * @property string $discount_button
 * @property string $price
 * @property integer $price_from
 * @property string $lvl
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
class ServiceSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\Service';

    public $title;
    public $handle;
    public $icon;
    public $image;
    public $type;
    public $is_popular;
    public $tags;
    public $image_2;
    public $image_3;
    public $text_title;
    public $text;
    public $members_title;
    public $members;
    public $related_services;
    public $title_seo;
    public $text_seo;
    public $text_spoiler;
    public $filials;
    public $intro_text;
    public $intro_image;
    public $discount_title;
    public $discount_price;
    public $discount_price_old;
    public $discount_button;
    public $price;
    public $price_from;
    public $lvl;
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
            [['title', 'handle', 'text_title', 'text', 'members_title', 'title_seo', 'text_seo', 'text_spoiler', 'intro_text', 'discount_title', 'discount_button', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string'],
            [['type'], 'string', 'max' => 50],
            [['is_popular', 'discount_price', 'discount_price_old', 'price', 'price_from', 'lvl', 'public'], 'number'],
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
        if ($attribute == 'type') return $this->filter_select($attribute);
        if ($attribute == 'is_popular') return $this->filter_checkbox($attribute);
        if ($attribute == 'text_title') return $this->filter_string($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'members_title') return $this->filter_string($attribute);
        if ($attribute == 'title_seo') return $this->filter_string($attribute);
        if ($attribute == 'text_seo') return $this->filter_string($attribute);
        if ($attribute == 'text_spoiler') return $this->filter_string($attribute);
        if ($attribute == 'intro_text') return $this->filter_string($attribute);
        if ($attribute == 'discount_title') return $this->filter_string($attribute);
        if ($attribute == 'discount_button') return $this->filter_string($attribute);
        if ($attribute == 'price_from') return $this->filter_checkbox($attribute);
        if ($attribute == 'lvl') return $this->filter_select($attribute);
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
    public function search_field_type($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'type', $parent_atttribute);
    }
    public function search_field_is_popular($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'is_popular', $parent_atttribute);
    }
    public function search_field_text_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text_title', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_members_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'members_title', $parent_atttribute);
    }
    public function search_field_title_seo($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title_seo', $parent_atttribute);
    }
    public function search_field_text_seo($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text_seo', $parent_atttribute);
    }
    public function search_field_text_spoiler($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text_spoiler', $parent_atttribute);
    }
    public function search_field_intro_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'intro_text', $parent_atttribute);
    }
    public function search_field_discount_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'discount_title', $parent_atttribute);
    }
    public function search_field_discount_button($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'discount_button', $parent_atttribute);
    }
    public function search_field_price_from($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'price_from', $parent_atttribute);
    }
    public function search_field_lvl($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'lvl', $parent_atttribute);
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