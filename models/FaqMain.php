<?php
namespace app\models;

use app\components\base\CActiveQuery;

class FaqMain extends Faq
{
    public static function find()
    {
        return new CActiveQueryFaqMain(get_called_class());
    }
}

class CActiveQueryFaqMain extends CActiveQuery {
    public function prepare($builder)
    {
        $this->andWhere(['service_id' => null]);
        return parent::prepare($builder);
    }
}