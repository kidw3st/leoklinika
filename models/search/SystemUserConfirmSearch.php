<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\SystemUserConfirmSearchParent;

class SystemUserConfirmSearch extends SystemUserConfirmSearchParent
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