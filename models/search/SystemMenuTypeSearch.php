<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\SystemMenuTypeSearchParent;

class SystemMenuTypeSearch extends SystemMenuTypeSearchParent
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