<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\PageBlockFaqSearchParent;

class PageBlockFaqSearch extends PageBlockFaqSearchParent
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