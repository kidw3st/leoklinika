<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "action".
 *
 * @property string $title
 * @property string $title2
 * @property string $handle
 * @property string $image
 * @property string $image_detail
 * @property string $active_from
 * @property string $active_to
 * @property string $price
 * @property string $price_old
 * @property string $prices
 * @property string $tags
 * @property string $service_id
 * @property string $description
 * @property string $button
 * @property string $text
 * @property string $text_2
 * @property string $profit
 * @property string $duration
 * @property integer $public
 * @property string $created_at
 * @property string $updated_at
 * @property string $weight
 */
class ActionSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\Action';

    public $title;
    public $title2;
    public $handle;
    public $image;
    public $image_detail;
    public $active_from;
    public $active_to;
    public $price;
    public $price_old;
    public $prices;
    public $tags;
    public $service_id;
    public $description;
    public $button;
    public $text;
    public $text_2;
    public $profit;
    public $duration;
    public $public;
    public $created_at;
    public $updated_at;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'title2', 'handle', 'active_from', 'active_to', 'service_id', 'description', 'button', 'text', 'text_2', 'profit', 'duration', 'created_at', 'updated_at'], 'string'],
            [['price', 'price_old', 'public'], 'number'],
            [['weight'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'title') return $this->filter_string($attribute);
        if ($attribute == 'title2') return $this->filter_string($attribute);
        if ($attribute == 'handle') return $this->filter_string($attribute);
        if ($attribute == 'active_from') return $this->filter_date($attribute);
        if ($attribute == 'active_to') return $this->filter_date($attribute);
        if ($attribute == 'service_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'description') return $this->filter_string($attribute);
        if ($attribute == 'button') return $this->filter_string($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'text_2') return $this->filter_string($attribute);
        if ($attribute == 'profit') return $this->filter_string($attribute);
        if ($attribute == 'duration') return $this->filter_string($attribute);
        if ($attribute == 'public') return $this->filter_checkbox($attribute);
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
    public function search_field_title2($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title2', $parent_atttribute);
    }
    public function search_field_handle($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'handle', $parent_atttribute);
    }
    public function search_field_active_from($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'active_from', $parent_atttribute);
    }
    public function search_field_active_to($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'active_to', $parent_atttribute);
    }
    public function search_field_service_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'service_id', $parent_atttribute);
    }
    public function search_field_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'description', $parent_atttribute);
    }
    public function search_field_button($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'button', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_text_2($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text_2', $parent_atttribute);
    }
    public function search_field_profit($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'profit', $parent_atttribute);
    }
    public function search_field_duration($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'duration', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
}