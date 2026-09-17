<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "service_block".
 *
 * @property string $title
 * @property string $block_type
 * @property string $text
 * @property string $image
 * @property string $link
 * @property string $link_title
 * @property string $block_class
 * @property string $service_id
 * @property integer $public
 * @property string $image_alt
 * @property string $weight
 */
class ServiceBlockSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\ServiceBlock';

    public $title;
    public $block_type;
    public $text;
    public $image;
    public $link;
    public $link_title;
    public $block_class;
    public $service_id;
    public $public;
    public $image_alt;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'text', 'link', 'link_title', 'service_id', 'image_alt'], 'string'],
            [['block_type', 'block_class'], 'string', 'max' => 50],
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
        if ($attribute == 'block_type') return $this->filter_select($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'link') return $this->filter_string($attribute);
        if ($attribute == 'link_title') return $this->filter_string($attribute);
        if ($attribute == 'block_class') return $this->filter_select($attribute);
        if ($attribute == 'service_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'public') return $this->filter_checkbox($attribute);
        if ($attribute == 'image_alt') return $this->filter_string($attribute);
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
    public function search_field_block_type($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'block_type', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_link($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link', $parent_atttribute);
    }
    public function search_field_link_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link_title', $parent_atttribute);
    }
    public function search_field_block_class($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'block_class', $parent_atttribute);
    }
    public function search_field_service_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'service_id', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
    public function search_field_image_alt($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'image_alt', $parent_atttribute);
    }
}