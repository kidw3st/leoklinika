<?php
namespace app\models;

use Yii;
use app\models\parents\ServiceBlockItemParent;

class ServiceBlockItem extends ServiceBlockItemParent
{
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
        
        ]);
    }

    /**
     * @param ServiceBlockItem $model
     * @return array
     */
    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        if ($model) {
            $fields = [];

            if ($model->block->block_type == 'texts') $fields = ['text', 'title_modal', 'text_modal', 'link', 'link_title', 'block_color'];
            if ($model->block->block_type == 'texts2') $fields = ['description'];
            if ($model->block->block_type == 'links') $fields = ['image', 'link', 'link_title', 'block_color'];

            if (!empty($fields)) {
                foreach ($fields as $field) {
                    $res['fields'][$field]['inserted'] = true;
                    $res['fields'][$field]['edited'] = true;
                }
            }

            if ($model->block->block_type == 'links') $res['fields']['block_color']['items'] = ['dark' => 'Синий', 'light' => 'Светлый'];
        }

        return $res;
    }

    public function getLink_attribute($class, $modal_class = false) {
        $res = [];

        if (!empty($this->link)) {
            $res[] = 'href="'.$this->link.'"';
            $res[] = 'class="'.$class.'"';
        } else {
            $res[] = 'href="#"';

            if (!empty($this->text_modal) && $modal_class !== false) {
                $res[] = 'data-target-id="'.$modal_class.'"';
                $res[] = 'class="'.$class.' _open-popup"';
            }
        }

        return implode(' ', $res);
    }

    public function getLink_title($default = 'Подробнее') {
        return !empty($this->link_title)?$this->link_title:$default;
    }
}