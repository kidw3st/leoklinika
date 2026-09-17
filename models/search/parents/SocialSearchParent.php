<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "social".
 *
 * @property string $title
 * @property string $type
 * @property string $link
 * @property integer $public
 * @property string $weight
 */
class SocialSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\Social';

    public $title;
    public $type;
    public $link;
    public $public;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'link'], 'string'],
            [['type'], 'string', 'max' => 50],
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
        if ($attribute == 'type') return $this->filter_select($attribute);
        if ($attribute == 'link') return $this->filter_string($attribute);
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
    public function search_field_type($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'type', $parent_atttribute);
    }
    public function search_field_link($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}