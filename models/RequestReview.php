<?php
namespace app\models;

use Yii;
use app\models\parents\RequestReviewParent;

/**
 * Class RequestReview
 * @package app\models
 *
 * @property string $selfUrl
 */
class RequestReview extends RequestReviewParent
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

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    public static function indexUrl() {
        return Yii::$app->urlManager->createUrl(['review/index']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['review/detail', 'id' => $this->id]);
    }
}