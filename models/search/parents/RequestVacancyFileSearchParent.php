<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "request_vacancy_file".
 *
 * @property string $title
 * @property string $file
 * @property string $request_vacancy_id
 */
class RequestVacancyFileSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\RequestVacancyFile';

    public $title;
    public $file;
    public $request_vacancy_id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'request_vacancy_id'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'title') return $this->filter_string($attribute);
        if ($attribute == 'request_vacancy_id') return $this->filter_link_ITo1($attribute);
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
    public function search_field_request_vacancy_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'request_vacancy_id', $parent_atttribute);
    }
}