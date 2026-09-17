<?php
namespace app\models;

use Yii;
use app\models\parents\PageParent;
use yii\caching\TagDependency;

class Page extends PageParent
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

        /** @var Page $model */
        if ($model) {
            if ($model->template == '2columns') $res['fields']['button_text']['edited'] = true;
            if ($model->template == '2columns') $res['fields']['form']['edited'] = true;
        }

        return $res;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        TagDependency::invalidate(Yii::$app->cache, ['page_blocks']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['page/index', 'handle' => $this->url]);
    }
}