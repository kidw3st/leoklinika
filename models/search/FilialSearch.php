<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\FilialSearchParent;

class FilialSearch extends FilialSearchParent
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