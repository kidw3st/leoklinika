<?php
namespace app\models;

use Yii;
use app\models\parents\PageBlockImageParent;

class PageBlockImage extends PageBlockImageParent
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

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        /** @var PageBlockImage $model */
        if ($model) {
            if ($model->page_block->block_type == 'gallery') $res['fields']['video_id']['edited'] = true;
            if ($model->page_block->block_type == 'gallery') $res['fields']['text']['edited'] = true;
        }

        return $res;
    }
}