<?php

namespace app\components\base;

use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class CActiveRecordTree extends CActiveRecord {
    public $tree_parent_id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['tree_parent_id'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'tree_parent_id' => 'Родительский элемент',
        ]);
    }

    public static function find() {
        $f = new CActiveQueryTree(get_called_class());
        return $f;
    }

    public function controllerSave()
    {
        if ($this->isNewRecord) {
            if (!($root = static::findOne($this->tree_parent_id))) {
                $root = static::find()->where(['depth'=>0])->one();
            }
            if (!$root) {
                return $this->makeRoot();
            } else {
                return $this->appendTo($root);
            }
        } else {
            return $this->save();
        }
    }

    public function setTreeHandle($tree_attribute, $attribute, $parent_tree_handle = false) {
        if ($this->depth != 0) {
            $new_tree_handle = $parent_tree_handle ?: '';
            if ($new_tree_handle == '') {
                $parent = $this->parents(1)->one();
                if ($parent && $parent->depth != 0) $new_tree_handle = $parent->{$tree_attribute} . '/';
            }
            $new_tree_handle .= $this->{$attribute};
            if ($this->{$tree_attribute} != $new_tree_handle) {
                $this->{$tree_attribute} = $new_tree_handle;
                $this->save(false, [$tree_attribute]);

                foreach ($this->children(1)->all() as $child) {
                    $child->setTreeHandle($tree_attribute, $attribute, $new_tree_handle . '/');
                }
            }
        } else {
            foreach ($this->children(1)->all() as $child) {
                $child->setTreeHandle($tree_attribute, $attribute, '');
            }
        }
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'tree');
        parent::afterDelete();
    }

    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'tree');
        parent::afterSave($insert, $changedAttributes);
    }

    public static function root() {
        return static::find()->orderBy('lft ASC')->one();
    }
}

class CActiveQueryTree extends CActiveQuery {
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }

    public function getDropDownList($template = 'title', $defaultValue = false) {
        $result = array();
        $items = $this->orderBy('lft ASC')->all();

        if($defaultValue !== false) {
            $result[0] = $defaultValue;
        }

        foreach($items as $item) {
            $result[$item->id] = str_repeat('- ', $item->depth) . ArrayHelper::getValue($item, $template);
        }
        return $result;
    }
}

?>