<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "email_stack".
 *
 * @property string $title
 * @property string $from
 * @property string $to
 * @property string $bcc
 * @property string $text
 * @property string $priority
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class EmailStackSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\EmailStack';

    public $title;
    public $from;
    public $to;
    public $bcc;
    public $text;
    public $priority;
    public $status;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'from', 'to', 'bcc', 'text', 'created_at', 'updated_at'], 'string'],
            [['priority'], 'integer'],
            [['status'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'title') return $this->filter_string($attribute);
        if ($attribute == 'from') return $this->filter_string($attribute);
        if ($attribute == 'to') return $this->filter_string($attribute);
        if ($attribute == 'bcc') return $this->filter_string($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'status') return $this->filter_select($attribute);
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

    public function search_field_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title', $parent_atttribute);
    }
    public function search_field_from($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'from', $parent_atttribute);
    }
    public function search_field_to($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'to', $parent_atttribute);
    }
    public function search_field_bcc($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'bcc', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_status($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'status', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
}