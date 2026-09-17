<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "member_expirience".
 *
 * @property string $from
 * @property string $to
 * @property string $text
 * @property string $member_id
 * @property integer $public
 */
class MemberExpirienceSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\MemberExpirience';

    public $from;
    public $to;
    public $text;
    public $member_id;
    public $public;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['from', 'to'], 'integer'],
            [['text', 'member_id'], 'string'],
            [['public'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'member_id') return $this->filter_link_ITo1($attribute);
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

    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_member_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'member_id', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}