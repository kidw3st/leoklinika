<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\PageBlockSlideSearchParent;

class PageBlockSlideSearch extends PageBlockSlideSearchParent
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