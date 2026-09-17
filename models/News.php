<?php
namespace app\models;

use Yii;
use app\models\parents\NewsParent;

/**
 * Class News
 * @package app\models
 *
 * @property string $selfUrl
 */
class News extends NewsParent
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
        return Yii::$app->urlManager->createUrl(['blog/index', 'type' => 'news']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['blog/detail', 'type' => 'news', 'handle' => $this->handle]);
    }
}