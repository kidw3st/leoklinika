<?php
namespace app\models;

use Yii;
use app\models\parents\ArticleParent;

/**
 * Class Article
 * @package app\models
 *
 * @property string $selfUrl
 */
class Article extends ArticleParent
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
        return Yii::$app->urlManager->createUrl(['blog/index', 'type' => 'articles']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['blog/detail', 'type' => 'articles', 'handle' => $this->handle]);
    }

    public function beforeSave($insert)
    {
        if (empty($this->date)) {
            $this->date_input = date('d.m.Y H:i:s');
        }

        return parent::beforeSave($insert);
    }
}