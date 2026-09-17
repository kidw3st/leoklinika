<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "page_block_slide".
 *
 * @property string $title
 * @property string $image
 * @property string $image_mobile
 * @property string $text
 * @property string $link
 * @property string $link_title
 * @property string $page_block_id
 * @property integer $public
 * @property string $weight
 */
class PageBlockSlideSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\PageBlockSlide';

    public $title;
    public $image;
    public $image_mobile;
    public $text;
    public $link;
    public $link_title;
    public $page_block_id;
    public $public;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'text', 'link', 'link_title', 'page_block_id'], 'string'],
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
        if ($attribute == 'link') return $this->filter_string($attribute);
        if ($attribute == 'link_title') return $this->filter_string($attribute);
        if ($attribute == 'page_block_id') return $this->filter_link_ITo1($attribute);
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
    public function search_field_link($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link', $parent_atttribute);
    }
    public function search_field_link_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link_title', $parent_atttribute);
    }
    public function search_field_page_block_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'page_block_id', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}