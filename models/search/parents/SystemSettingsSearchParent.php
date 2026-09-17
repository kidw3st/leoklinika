<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_settings".
 *
 * @property string $title
 * @property string $module
 * @property string $code
 * @property string $type
 * @property string $value
 * @property string $model_class
 * @property string $value_model
 * @property string $value_file
 * @property string $options
 * @property string $weight
 */
class SystemSettingsSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemSettings';

    public $title;
    public $module;
    public $code;
    public $type;
    public $value;
    public $model_class;
    public $value_model;
    public $value_file;
    public $options;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'module', 'code', 'value'], 'string'],
            [['type', 'value_model'], 'number'],
            [['model_class'], 'string', 'max' => 50],
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
        if ($attribute == 'module') return $this->filter_string($attribute);
        if ($attribute == 'code') return $this->filter_string($attribute);
        if ($attribute == 'type') return $this->filter_select($attribute);
        if ($attribute == 'value') return $this->filter_string($attribute);
        if ($attribute == 'model_class') return $this->filter_select($attribute);
        if ($attribute == 'value_model') return $this->filter_select($attribute);
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
    public function search_field_module($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'module', $parent_atttribute);
    }
    public function search_field_code($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'code', $parent_atttribute);
    }
    public function search_field_type($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'type', $parent_atttribute);
    }
    public function search_field_value($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'value', $parent_atttribute);
    }
    public function search_field_model_class($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'model_class', $parent_atttribute);
    }
    public function search_field_value_model($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'value_model', $parent_atttribute);
    }
}