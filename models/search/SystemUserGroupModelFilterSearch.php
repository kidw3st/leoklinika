<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\SystemUserGroupModelFilterSearchParent;

class SystemUserGroupModelFilterSearch extends SystemUserGroupModelFilterSearchParent
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