<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_menu".
 *
 * @property string $title
 * @property string $url
 * @property string $types
 * @property integer $is_service
 * @property string $title_2
 * @property string $title_3
 * @property integer $public
 */
class SystemMenuSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemMenu';

    public $title;
    public $url;
    public $types;
    public $is_service;
    public $title_2;
    public $title_3;
    public $public;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'url', 'title_2', 'title_3'], 'string'],
            [['is_service', 'public'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'title') return $this->filter_string($attribute);
        if ($attribute == 'url') return $this->filter_string($attribute);
        if ($attribute == 'is_service') return $this->filter_checkbox($attribute);
        if ($attribute == 'title_2') return $this->filter_string($attribute);
        if ($attribute == 'title_3') return $this->filter_string($attribute);
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
    public function search_field_url($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'url', $parent_atttribute);
    }
    public function search_field_is_service($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'is_service', $parent_atttribute);
    }
    public function search_field_title_2($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title_2', $parent_atttribute);
    }
    public function search_field_title_3($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title_3', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}