<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_structure".
 *
 * @property string $controller
 * @property string $url
 * @property string $h1_title
 * @property string $created_at
 * @property string $updated_at
 * @property string $weight
 * @property integer $public
 */
class SystemStructureSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemStructure';

    public $controller;
    public $url;
    public $h1_title;
    public $created_at;
    public $updated_at;
    public $weight;
    public $public;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['controller', 'url', 'h1_title', 'created_at', 'updated_at'], 'string'],
            [['weight'], 'integer'],
            [['public'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'controller') return $this->filter_string($attribute);
        if ($attribute == 'url') return $this->filter_string($attribute);
        if ($attribute == 'h1_title') return $this->filter_string($attribute);
        if ($attribute == 'created_at') return $this->filter_date($attribute);
        if ($attribute == 'updated_at') return $this->filter_date($attribute);
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

    public function search_field_controller($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'controller', $parent_atttribute);
    }
    public function search_field_url($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'url', $parent_atttribute);
    }
    public function search_field_h1_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'h1_title', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}