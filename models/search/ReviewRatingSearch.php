<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\ReviewRatingSearchParent;

class ReviewRatingSearch extends ReviewRatingSearchParent
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