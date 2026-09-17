<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_user_social".
 *
 * @property string $user_id
 * @property string $soc_id
 * @property string $soc_name
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 */
class SystemUserSocialSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemUserSocial';

    public $user_id;
    public $soc_id;
    public $soc_name;
    public $data;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['user_id', 'soc_id', 'soc_name', 'created_at', 'updated_at'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'user_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'soc_id') return $this->filter_string($attribute);
        if ($attribute == 'soc_name') return $this->filter_string($attribute);
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

    public function search_field_user_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'user_id', $parent_atttribute);
    }
    public function search_field_soc_id($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'soc_id', $parent_atttribute);
    }
    public function search_field_soc_name($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'soc_name', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
}