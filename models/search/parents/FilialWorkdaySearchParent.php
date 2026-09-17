<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "filial_workday".
 *
 * @property string $date
 * @property string $times
 * @property string $filial_id
 */
class FilialWorkdaySearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\FilialWorkday';

    public $date;
    public $times;
    public $filial_id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['date', 'times', 'filial_id'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'date') return $this->filter_date($attribute);
        if ($attribute == 'times') return $this->filter_string($attribute);
        if ($attribute == 'filial_id') return $this->filter_link_ITo1($attribute);
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

    public function search_field_date($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'date', $parent_atttribute);
    }
    public function search_field_times($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'times', $parent_atttribute);
    }
    public function search_field_filial_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'filial_id', $parent_atttribute);
    }
}