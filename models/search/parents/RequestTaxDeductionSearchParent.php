<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "request_tax_deduction".
 *
 * @property string $patient
 * @property string $name
 * @property string $relation
 * @property string $birthday
 * @property string $inn
 * @property string $card_number
 * @property string $year
 * @property string $passport
 * @property string $passport_date
 * @property string $patient_name
 * @property string $patient_inn
 * @property string $patient_birthday
 * @property string $patient_passport
 * @property string $patient_passport_date
 * @property string $email
 * @property string $phone
 * @property string $delivery_method
 * @property string $page_id
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $og_title
 * @property string $og_description
 * @property string $og_image
 * @property string $created_at
 * @property string $updated_at
 */
class RequestTaxDeductionSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\RequestTaxDeduction';

    public $patient;
    public $name;
    public $relation;
    public $birthday;
    public $inn;
    public $card_number;
    public $year;
    public $passport;
    public $passport_date;
    public $patient_name;
    public $patient_inn;
    public $patient_birthday;
    public $patient_passport;
    public $patient_passport_date;
    public $email;
    public $phone;
    public $delivery_method;
    public $page_id;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $og_title;
    public $og_description;
    public $og_image;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['patient', 'delivery_method'], 'string', 'max' => 50],
            [['name', 'relation', 'birthday', 'inn', 'card_number', 'year', 'passport', 'passport_date', 'patient_name', 'patient_inn', 'patient_birthday', 'patient_passport', 'patient_passport_date', 'email', 'phone', 'page_id', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'created_at', 'updated_at'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function field_filter_input($attribute) {
        if ($attribute == 'patient') return $this->filter_select($attribute);
        if ($attribute == 'name') return $this->filter_string($attribute);
        if ($attribute == 'relation') return $this->filter_string($attribute);
        if ($attribute == 'birthday') return $this->filter_date($attribute);
        if ($attribute == 'inn') return $this->filter_string($attribute);
        if ($attribute == 'card_number') return $this->filter_string($attribute);
        if ($attribute == 'year') return $this->filter_string($attribute);
        if ($attribute == 'passport') return $this->filter_string($attribute);
        if ($attribute == 'passport_date') return $this->filter_date($attribute);
        if ($attribute == 'patient_name') return $this->filter_string($attribute);
        if ($attribute == 'patient_inn') return $this->filter_string($attribute);
        if ($attribute == 'patient_birthday') return $this->filter_date($attribute);
        if ($attribute == 'patient_passport') return $this->filter_string($attribute);
        if ($attribute == 'patient_passport_date') return $this->filter_date($attribute);
        if ($attribute == 'phone') return $this->filter_string($attribute);
        if ($attribute == 'delivery_method') return $this->filter_select($attribute);
        if ($attribute == 'page_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'seo_title') return $this->filter_string($attribute);
        if ($attribute == 'seo_description') return $this->filter_string($attribute);
        if ($attribute == 'seo_keywords') return $this->filter_string($attribute);
        if ($attribute == 'og_title') return $this->filter_string($attribute);
        if ($attribute == 'og_description') return $this->filter_string($attribute);
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

    public function search_field_patient($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'patient', $parent_atttribute);
    }
    public function search_field_name($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'name', $parent_atttribute);
    }
    public function search_field_relation($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'relation', $parent_atttribute);
    }
    public function search_field_birthday($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'birthday', $parent_atttribute);
    }
    public function search_field_inn($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'inn', $parent_atttribute);
    }
    public function search_field_card_number($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'card_number', $parent_atttribute);
    }
    public function search_field_year($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'year', $parent_atttribute);
    }
    public function search_field_passport($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'passport', $parent_atttribute);
    }
    public function search_field_passport_date($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'passport_date', $parent_atttribute);
    }
    public function search_field_patient_name($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'patient_name', $parent_atttribute);
    }
    public function search_field_patient_inn($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'patient_inn', $parent_atttribute);
    }
    public function search_field_patient_birthday($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'patient_birthday', $parent_atttribute);
    }
    public function search_field_patient_passport($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'patient_passport', $parent_atttribute);
    }
    public function search_field_patient_passport_date($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'patient_passport_date', $parent_atttribute);
    }
    public function search_field_phone($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'phone', $parent_atttribute);
    }
    public function search_field_delivery_method($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'delivery_method', $parent_atttribute);
    }
    public function search_field_page_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'page_id', $parent_atttribute);
    }
    public function search_field_seo_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'seo_title', $parent_atttribute);
    }
    public function search_field_seo_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'seo_description', $parent_atttribute);
    }
    public function search_field_seo_keywords($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'seo_keywords', $parent_atttribute);
    }
    public function search_field_og_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'og_title', $parent_atttribute);
    }
    public function search_field_og_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'og_description', $parent_atttribute);
    }
    public function search_field_created_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'created_at', $parent_atttribute);
    }
    public function search_field_updated_at($query, $parent_atttribute = '') {
        $this->search_type_date($query, 'updated_at', $parent_atttribute);
    }
}