<?php
namespace app\models;

use app\helpers\base\SystemHelper;
use Yii;
use app\models\parents\SystemMenuParent;

class SystemMenu extends SystemMenuParent
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

    public function getGenerate_url() {
        return SystemHelper::LanguageLink($this->url);
    }

    public function getBasic_url() {
        return $this->url;
    }
}