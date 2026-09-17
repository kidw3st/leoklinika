<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "vacancy_info".
 *
 * @property string $title
 * @property string $text
 * @property string $vacancy_id
 * @property integer $public
 * @property string $weight
 */
class VacancyInfoSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\VacancyInfo';

    public $title;
    public $text;
    public $vacancy_id;
    public $public;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'text', 'vacancy_id'], 'string'],
            [['public'], 'number'],
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
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'vacancy_id') return $this->filter_link_ITo1($attribute);
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
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_vacancy_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'vacancy_id', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}