<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\MemberVideoSearchParent;

class MemberVideoSearch extends MemberVideoSearchParent
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