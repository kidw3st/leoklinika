<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\SystemNoticeTemplateEmailSearchParent;

class SystemNoticeTemplateEmailSearch extends SystemNoticeTemplateEmailSearchParent
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
}