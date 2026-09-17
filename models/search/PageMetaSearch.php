<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\PageMetaSearchParent;

class PageMetaSearch extends PageMetaSearchParent
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