<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "filial".
 *
 * @property string $title
 * @property string $city
 * @property string $address
 * @property string $phones
 * @property string $emails
 * @property string $times
 * @property integer $is_default
 * @property string $coord_x
 * @property string $coord_y
 * @property integer $public
 * @property string $weight
 */
class FilialSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\Filial';

    public $title;
    public $city;
    public $address;
    public $phones;
    public $emails;
    public $times;
    public $is_default;
    public $coord_x;
    public $coord_y;
    public $public;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'city', 'address', 'phones', 'emails'], 'string'],
            [['is_default', 'coord_x', 'coord_y', 'public'], 'number'],
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
        if ($attribute == 'city') return $this->filter_string($attribute);
        if ($attribute == 'address') return $this->filter_string($attribute);
        if ($attribute == 'phones') return $this->filter_string($attribute);
        if ($attribute == 'emails') return $this->filter_string($attribute);
        if ($attribute == 'is_default') return $this->filter_checkbox($attribute);
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
    public function search_field_city($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'city', $parent_atttribute);
    }
    public function search_field_address($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'address', $parent_atttribute);
    }
    public function search_field_phones($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'phones', $parent_atttribute);
    }
    public function search_field_emails($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'emails', $parent_atttribute);
    }
    public function search_field_is_default($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'is_default', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}