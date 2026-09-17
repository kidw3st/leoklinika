<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "system_user".
 *
 * @property string $login_username
 * @property string $login_email
 * @property string $login_phone
 * @property string $password
 * @property string $auth_key
 * @property string $name
 * @property string $surname
 * @property string $second_name
 * @property string $access_token
 * @property string $image
 * @property string $status
 * @property string $cookieArray
 * @property integer $admin
 * @property string $group_id
 * @property string $created_at
 * @property string $updated_at
 */
class SystemUserSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\SystemUser';

    public $login_username;
    public $login_email;
    public $login_phone;
    public $password;
    public $auth_key;
    public $name;
    public $surname;
    public $second_name;
    public $access_token;
    public $image;
    public $status;
    public $cookieArray;
    public $admin;
    public $group_id;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['login_username', 'login_email', 'auth_key', 'name', 'surname', 'second_name', 'access_token', 'group_id', 'created_at', 'updated_at'], 'string'],
            [['login_phone', 'status', 'admin'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'login_username') return $this->filter_string($attribute);
        if ($attribute == 'auth_key') return $this->filter_string($attribute);
        if ($attribute == 'name') return $this->filter_string($attribute);
        if ($attribute == 'surname') return $this->filter_string($attribute);
        if ($attribute == 'second_name') return $this->filter_string($attribute);
        if ($attribute == 'access_token') return $this->filter_string($attribute);
        if ($attribute == 'status') return $this->filter_select($attribute);
        if ($attribute == 'admin') return $this->filter_checkbox($attribute);
        if ($attribute == 'group_id') return $this->filter_link_ITo1($attribute);
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

    public function search_field_login_username($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'login_username', $parent_atttribute);
    }
    public function search_field_auth_key($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'auth_key', $parent_atttribute);
    }
    public function search_field_name($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'name', $parent_atttribute);
    }
    public function search_field_surname($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'surname', $parent_atttribute);
    }
    public function search_field_second_name($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'second_name', $parent_atttribute);
    }
    public function search_field_access_token($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'access_token', $parent_atttribute);
    }
    public function search_field_status($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'status', $parent_atttribute);
    }
    public function search_field_admin($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'admin', $parent_atttribute);
    }
    public function search_field_group_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'group_id', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
}