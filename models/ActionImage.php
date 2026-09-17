<?php
namespace app\models;

use Yii;
use app\models\parents\ActionImageParent;

class ActionImage extends ActionImageParent
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

        return $res;
    }
}