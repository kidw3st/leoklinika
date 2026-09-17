<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_user_group_model_filter_value".
 *
 * @property string $value_id
 * @property string $user_group_model_filter_id
 */
class SystemUserGroupModelFilterValueSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemUserGroupModelFilterValue';

    public $value_id;
    public $user_group_model_filter_id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['value_id', 'user_group_model_filter_id'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'value_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'user_group_model_filter_id') return $this->filter_link_ITo1($attribute);
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

    public function search_field_value_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'value_id', $parent_atttribute);
    }
    public function search_field_user_group_model_filter_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'user_group_model_filter_id', $parent_atttribute);
    }
}