<?php

namespace app\components\base;

use app\helpers\base\SystemHelper;
use yii\base\Model;
use yii\bootstrap4\Html;

class ModelSearch extends Model {
    public static $main_model_class = '';

    private function getParent_attribute($parent_attribute, $attribute) {
        if (empty($parent_attribute)) {
            $cn = static::$main_model_class;
            $options = $cn::getOptions();
            if (!empty($options['fields'][$attribute]['locale'])) {
                $parent_attribute = $cn::tableName() . '_locale' . '.';
            } else {
                $parent_attribute = $cn::tableName() . '.';
            }
        }

        return $parent_attribute;
    }

    //------- FILTER

    public function field_filter_input($attribute) {
        return false;
    }

    public function filter_checkbox($attribute) {
        return Html::activeDropDownList($this, $attribute, [0 => '', 1 => 'Да', 2 => 'Нет'], ['class' => 'form-control']);
    }

    public function filter_string($attribute) {
        return Html::activeInput('text', $this, $attribute, ['class' => 'form-control']);
    }

    public function filter_select($attribute) {
        $cn = static::$main_model_class;
        $list = $cn::{$attribute.'List'}();
        $list = ['' => ''] + $list;
        return Html::activeDropDownList($this, $attribute, $list, ['class' => 'form-control']);
    }

    public function filter_date($attribute) {
        return Html::activeInput('date', $this, $attribute, ['class' => 'form-control']);
    }

    public function filter_link_ITo1($attribute) {
        return Html::activeInput('text', $this, $attribute, ['class' => 'form-control']);
    }

    //------ SEARCH

    public function search_type_checkbox($query, $attribute, $parent_attribute = '') {
        $parent_attribute = $this->getParent_attribute($parent_attribute, $attribute);

        if ($this->{$attribute} == 1) {
            $query->andWhere([$parent_attribute.$attribute => 1]);
        } else {
            $query->andWhere(['OR', [$parent_attribute.$attribute => 0], [$parent_attribute.$attribute => ''], [$parent_attribute.$attribute => null]]);
        }
    }

    public function search_type_string($query, $attribute, $parent_attribute = '') {
        $parent_attribute = $this->getParent_attribute($parent_attribute, $attribute);

        $sw = preg_split('/\s+/', $this->{$attribute});
        foreach ($sw as $swItem) {
            $query->andWhere(['like', $parent_attribute.$attribute, $swItem]);
        }
    }

    public function search_type_select($query, $attribute, $parent_attribute = '') {
        $parent_attribute = $this->getParent_attribute($parent_attribute, $attribute);

        $query->andWhere(['like', $parent_attribute.$attribute, $this->$attribute]);
    }

    public function search_type_date($query, $attribute, $parent_attribute = '') {
        $parent_attribute = $this->getParent_attribute($parent_attribute, $attribute);

        $timestamp = strtotime($this->$attribute);

        $query->andWhere(['>=', $parent_attribute.$attribute, date('Y-m-d 00:00:00', $timestamp)]);
        $query->andWhere(['<=', $parent_attribute.$attribute, date('Y-m-d 23:59:59', $timestamp)]);
    }

    public function search_type_link_ITo1($query, $attribute, $parent_attribute = '') {
        $parent_attribute = $this->getParent_attribute($parent_attribute, $attribute);

        $main_cn = static::$main_model_class;
        $options = $main_cn::getOptions();

        if (!empty($options['fields'][$attribute])) {
            $field = $options['fields'][$attribute];
            $cn = $field['class'];
            $cn_search = $cn::$search_model_class;
            $options = $cn::getOptions();
            $search_model = new $cn_search();
            if (!empty($options['fields'][$field['list_template']])) {
                $parent_alias = $attribute . '_' . $field['linki1Variable'];

                $query->leftJoin($cn::tableName() . ' ' . $parent_alias, $parent_attribute.$attribute . ' = ' . $parent_alias . '.id');

                if (!empty($options['fields'][$field['list_template']]['locale'])) {
                    $language_id = SystemHelper::Language()->id;
                    $locale_parent_alias = $parent_alias . '_locale';

                    $query->leftJoin($cn::tableNameLocale() . ' ' . $locale_parent_alias, $parent_alias . '.id = ' . $locale_parent_alias . '.locale_parent_id AND ' . $locale_parent_alias . '.language_id = ' . $language_id);

                    $parent_alias = $locale_parent_alias;
                }

                $search_model->{$field['list_template']} = $this->{$attribute};
                $search_model->{'search_field_'.$field['list_template']}($query, $parent_alias . '.');
            }
        }
    }
}