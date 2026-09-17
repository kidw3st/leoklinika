<?php

namespace app\controllers;

use app\components\base\Pagination;
use app\controllers\base\PublicController;
use app\models\Action;
use app\models\RequestReview;
use app\models\Service;
use app\models\SystemStructure;
use Yii;

class ServiceController extends PublicController
{
    public $doPageController = true;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/<handle:[-\_\/\w]+>',
                'route' => static::$uniqId.'/detail',
                'encodeParams' => false,
            ],
            [
                'pattern' => '/',
                'route' => static::$uniqId.'/index',
            ],
        ];
    }

    public static $uniqId = 'service';
    public static $controllerTitle = 'Услуга';

    public function actionIndex()
    {
        $this->body_class = 'services-general';
        $this->main_class = 'main__services';

        $actions = Action::find()->published()->active_by_dates()->ordered()->limit(10)->all();
        $directions = Service::find_base()->published()->orderBy('lft ASC')->andWhere(['depth' => 1])->all();

        return $this->render('index', ['actions' => $actions, 'directions' => $directions]);
    }

    public function actionDetail($handle)
    {
        /** @var Service $service */
        $service = Service::find_base()->where(['handle_tree' => $handle])->published()->oneOrNotFound();
        $this->setPageParams($service, false);
        $this->addToBreadcrumbTree($service);
        $reviews = RequestReview::find()->published()->orderBy('date DESC')->limit(5)->all();
        $actions = Action::find()->published()->active_by_dates()->ordered()->limit(10)->all();

        $template = 'category1';
        $this->body_class = 'services-directions';
        if ($service->depth > 1) {
            $template = 'category2';
            $this->body_class = 'services-categories';
        }
        if ($service->depth > 2) {
            $template = 'detail';
            $this->body_class = 'services-detail';
        }

        if (!empty($service->lvl)) {
            if ($service->lvl == 1) {
                $template = 'category1';
                $this->body_class = 'services-directions';
            }
            if ($service->lvl == 12) {
                $template = 'category1v2';
                $this->body_class = 'services-directions';
            }
            if ($service->lvl == 2) {
                $template = 'category2';
                $this->body_class = 'services-categories';
            }
            if ($service->lvl == 22) {
                $template = 'category2v2';
                $this->body_class = 'services-categories';
            }
            if ($service->lvl == 3) {
                $template = 'detail';
                $this->body_class = 'services-detail';
            }
        }

        return $this->render($template, [
            'service' => $service,
            'reviews' => $reviews,
            'actions' => $actions,
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Service'])->published()->one();
        if (!$structure) return;

        $controller->addArray('service/index', [], date('c'), 'weekly', '0.8');

        /** @var Service[] $items */
        $items = Service::find()->published()->andWhere(['>', 'lft', 1])->all();
        foreach ($items as $item) {
            $controller->addArrayFull($item->selfUrl, $item->updated_at_obj->format('c'), 'weekly', '0.8');
        }
    }
}
