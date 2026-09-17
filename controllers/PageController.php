<?php

namespace app\controllers;

use app\controllers\base\PublicController;
use app\models\Page;
use app\models\SystemStructure;
use Yii;

class PageController extends PublicController
{
    public $doPageController = false;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/<handle:[-\_\/\w]+>',
                'route' => static::$uniqId.'/index',
                'encodeParams' => false,
            ],
            [
                'pattern' => '/',
                'route' => static::$uniqId.'/index',
            ],
        ];
    }

    public static $uniqId = 'page';
    public static $controllerTitle = 'Страницы';

    public function actionIndex($handle = '/') {
        /** @var Page $page */
        $page = Page::find()->where(['url' => $handle])->published()->oneOrNotFound();
        $this->setPageParams($page, false);

        if ($page->url != '/') {
            $this->body_class = 'about__page page';
            $this->main_class = 'main-'.$page->url;
        }

        if ($page->template == '2columns') $this->body_class = 'patients page';

        return $this->render($page->template, ['item' => $page]);
    }

    public function actionAfterpage($handle = '') {
        $page = Page::find()->where(['url' => $handle])->published()->one();
        if ($page) {
            return $this->renderPartial('index', ['item' => $page]);
        } else {
            return '';
        }
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Page'])->published()->one();
        if (!$structure) return;

        /** @var Page[] $items */
        $items = Page::find()->published()->all();
        foreach ($items as $item) {
            $controller->addArrayFull($item->selfUrl, $item->updated_at_obj->format('c'), ($item->url=='/')?'monthly':'weekly', ($item->url=='/')?'1.0':'0.8');
        }
    }
}
