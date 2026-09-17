<?php

namespace app\controllers;

use app\components\base\Pagination;
use app\controllers\base\PublicController;
use app\models\RequestReview;
use app\models\SystemSettings;
use app\models\SystemStructure;
use Yii;

class ReviewController extends PublicController
{
    public $doPageController = true;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/',
                'route' => static::$uniqId.'/index',
            ],
        ];
    }

    public static $uniqId = 'review';
    public static $controllerTitle = 'Отзывы';

    public function actionIndex($page = 1, $more = false, $from = false)
    {
        $this->body_class = 'documents page';

        $criteria = RequestReview::find()->published()->orderBy('date DESC');

        $page_size = SystemSettings::getParam('review', 'page_size', 1);
        $params = [];
        if ($more && $from) $params['from'] = $from;
        if (!$more) $params['from'] = $page;
        $pages = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params + ['from' => $page], $page - 1);
        $pages_more = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params + ['more' => 1], $page - 1);
        if ($more) {
            $items = $criteria->offset($page_size * (($from?$from:1) - 1))->limit($pages->limit + $pages->offset - $page_size * (($from?$from:1) - 1))->all();
        } else {
            $items = $criteria->limit($pages->limit)->offset($pages->offset)->all();
        }

        return $this->render('index', [
            'items' => $items,
            'pages' => $pages,
            'pages_more' => $pages_more,
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Review'])->published()->one();
        if (!$structure) return;

        $controller->addArray('review/index', [], date('c'), 'weekly', '0.8');
    }
}
