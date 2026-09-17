<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\PageBlockAdvantageSearchParent;

class PageBlockAdvantageSearch extends PageBlockAdvantageSearchParent
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