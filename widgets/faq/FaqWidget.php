<?php

namespace app\widgets\faq;

use app\components\base\Pagination;
use app\models\Faq;
use app\models\PageBlock;
use Yii;

/**
 * Class FaqWidget
 * @package app\widgets\faq
 *
 * @property PageBlock $block
 */
class FaqWidget extends \yii\base\Widget {
    public $title;
    public $title_class;
    public $service_id = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $page = Yii::$app->request->get('page_'.$this->id, 1);

        $criteria = Faq::find()->ordered()->published();
        if ($this->service_id) {
            $criteria->andWhere(['service_id' => $this->service_id]);
        } else {
            $criteria->andWhere(['service_id' => null]);
        }

        $pages = Pagination::getPages($criteria->count(), 5, Yii::$app->controller->action->uniqueId, Yii::$app->request->queryParams, $page - 1, 'page_'.$this->id);

        $faqs = $criteria->limit($pages->limit + $pages->offset)->all();

        if (count($faqs) > 0) {
            return $this->render('index', [
                'title' => $this->title,
                'faqs' => $faqs,
                'pages' => $pages,
                'pjax_id' => 'faqs_' . $this->id,
            ]);
        }
        return '';
    }
}