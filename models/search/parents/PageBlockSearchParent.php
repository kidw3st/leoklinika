<?php 
namespace app\models\search\parents;

use app\components\base\ModelSearch;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "page_block".
 *
 * @property string $title
 * @property string $title_2
 * @property integer $show_title
 * @property string $block_type
 * @property string $description
 * @property string $info
 * @property string $text
 * @property string $image
 * @property string $image_mobile
 * @property string $form_type
 * @property string $link
 * @property string $link_title
 * @property integer $only_popular
 * @property integer $only_lead
 * @property string $video_title
 * @property string $video_id
 * @property string $success_text
 * @property string $page_id
 * @property integer $public
 * @property string $weight
 */
class PageBlockSearchParent extends ModelSearch {
    public static $main_model_class = '\\app\\models\\PageBlock';

    public $title;
    public $title_2;
    public $show_title;
    public $block_type;
    public $description;
    public $info;
    public $text;
    public $image;
    public $image_mobile;
    public $form_type;
    public $link;
    public $link_title;
    public $only_popular;
    public $only_lead;
    public $video_title;
    public $video_id;
    public $success_text;
    public $page_id;
    public $public;
    public $weight;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'title_2', 'description', 'info', 'text', 'link', 'link_title', 'video_title', 'video_id', 'success_text', 'page_id'], 'string'],
            [['show_title', 'only_popular', 'only_lead', 'public'], 'number'],
            [['block_type', 'form_type'], 'string', 'max' => 50],
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
        if ($attribute == 'title_2') return $this->filter_string($attribute);
        if ($attribute == 'show_title') return $this->filter_checkbox($attribute);
        if ($attribute == 'block_type') return $this->filter_select($attribute);
        if ($attribute == 'description') return $this->filter_string($attribute);
        if ($attribute == 'info') return $this->filter_string($attribute);
        if ($attribute == 'text') return $this->filter_string($attribute);
        if ($attribute == 'form_type') return $this->filter_select($attribute);
        if ($attribute == 'link') return $this->filter_string($attribute);
        if ($attribute == 'link_title') return $this->filter_string($attribute);
        if ($attribute == 'only_popular') return $this->filter_checkbox($attribute);
        if ($attribute == 'only_lead') return $this->filter_checkbox($attribute);
        if ($attribute == 'video_title') return $this->filter_string($attribute);
        if ($attribute == 'video_id') return $this->filter_link_ITo1($attribute);
        if ($attribute == 'success_text') return $this->filter_string($attribute);
        if ($attribute == 'page_id') return $this->filter_link_ITo1($attribute);
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
    public function search_field_title_2($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'title_2', $parent_atttribute);
    }
    public function search_field_show_title($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'show_title', $parent_atttribute);
    }
    public function search_field_block_type($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'block_type', $parent_atttribute);
    }
    public function search_field_description($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'description', $parent_atttribute);
    }
    public function search_field_info($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'info', $parent_atttribute);
    }
    public function search_field_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'text', $parent_atttribute);
    }
    public function search_field_form_type($query, $parent_atttribute = '') {
        $this->search_type_select($query, 'form_type', $parent_atttribute);
    }
    public function search_field_link($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link', $parent_atttribute);
    }
    public function search_field_link_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'link_title', $parent_atttribute);
    }
    public function search_field_only_popular($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'only_popular', $parent_atttribute);
    }
    public function search_field_only_lead($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'only_lead', $parent_atttribute);
    }
    public function search_field_video_title($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'video_title', $parent_atttribute);
    }
    public function search_field_video_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'video_id', $parent_atttribute);
    }
    public function search_field_success_text($query, $parent_atttribute = '') {
        $this->search_type_string($query, 'success_text', $parent_atttribute);
    }
    public function search_field_page_id($query, $parent_atttribute = '') {
        $this->search_type_link_ITo1($query, 'page_id', $parent_atttribute);
    }
    public function search_field_public($query, $parent_atttribute = '') {
        $this->search_type_checkbox($query, 'public', $parent_atttribute);
    }
}