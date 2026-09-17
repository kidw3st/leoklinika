<?php
namespace app\models;

use app\components\base\Image;
use Yii;
use app\models\parents\ActionParent;

/**
 * Class Action
 * @package app\models
 *
 * @property string $selfUrl
 * @property Image $image_banner_obj
 */
class Action extends ActionParent
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
        return Yii::$app->urlManager->createUrl(['actions/index']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['actions/detail', 'handle' => $this->handle]);
    }

    public function getImage_banner_obj() {
        if (!empty($this->image_detail)) return $this->image_detail_obj;

        return $this->image_obj;
    }

    public function getDates_str() {
        $res = [];

        if (!empty($this->active_from)) $res[] = 'с ' . $this->active_from_obj->format('d.m.Y');
        if (!empty($this->active_to)) $res[] = 'по ' . $this->active_to_obj->format('d.m.Y');

        return implode(' ', $res);
    }
}