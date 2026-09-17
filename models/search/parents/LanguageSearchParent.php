<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "language".
 *
 * @property string $title
 * @property string $handle
 * @property string $short_title
 * @property integer $is_main
 * @property string $i18n_code
 * @property string $weight
 * @property integer $public
 */
class LanguageSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\Language';

    public $title;
    public $handle;
    public $short_title;
    public $is_main;
    public $i18n_code;
    public $weight;
    public $public;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'handle', 'short_title', 'i18n_code'], 'string'],
            [['is_main', 'public'], 'number'],
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
        if ($attribute == 'handle') return $this->filter_string($attribute);
        if ($attribute == 'short_title') return $this->filter_string($attribute);
        if ($attribute == 'is_main') return $this->filter_checkbox($attribute);
        if ($attribute == 'i18n_code') return $this->filter_string($attribute);
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
    public function search_field_handle($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'handle', $parent_atttribute);
    }
    public function search_field_short_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'short_title', $parent_atttribute);
    }
    public function search_field_is_main($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'is_main', $parent_atttribute);
    }
    public function search_field_i18n_code($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'i18n_code', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}