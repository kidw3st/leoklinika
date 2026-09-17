<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_menu_type".
 *
 * @property string $title
 * @property string $handle
 */
class SystemMenuTypeSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemMenuType';

    public $title;
    public $handle;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'handle'], 'string'],
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
}