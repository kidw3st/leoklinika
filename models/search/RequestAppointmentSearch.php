<?php
namespace app\models\search;

use Yii;
use app\models\search\parents\RequestAppointmentSearchParent;

class RequestAppointmentSearch extends RequestAppointmentSearchParent
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