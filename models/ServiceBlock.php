<?php
namespace app\models;

use Yii;
use app\models\parents\ServiceBlockParent;

class ServiceBlock extends ServiceBlockParent
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
    * @param ServiceBlock $model
    * @return array
    */
    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        if ($model) {
            if ($model->block_type == 'text') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'text') $res['fields']['link']['edited'] = true;
            if ($model->block_type == 'text') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'text2') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'text2') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'text2') $res['fields']['image_alt']['edited'] = true;
            if ($model->block_type == 'text2') $res['fields']['link']['edited'] = true;
            if ($model->block_type == 'text2') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'texts2') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'texts2') $res['fields']['block_class']['edited'] = true;
            if ($model->block_type == 'texts2') $res['fields']['block_class']['items'] = ['large' => 'Большой'];
        }

        return $res;
    }

    public function getAdminTabs($url = false, $activeMenu = false)
    {
        $res = parent::getAdminTabs($url, $activeMenu);

        $result = [];
        $result['self'] = $res['self'];

        if (in_array($this->block_type, ['texts', 'texts2', 'links'])) $result['items'] = $res['items'];
        if (in_array($this->block_type, ['texts', 'texts2'])) $result['items']['label'] = 'Плашка';
        if (in_array($this->block_type, ['links'])) $result['items']['label'] = 'Ссылка';

        if (count($result) == 1) $result = [];

        return $result;
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