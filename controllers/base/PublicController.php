<?php

namespace app\controllers\base;

use app\components\base\CActiveQueryTree;
use app\controllers\system\SitemapController;
use app\helpers\base\MenuHelper;
use app\helpers\base\SystemHelper;
use app\models\SystemSettings;
use app\models\SystemStructure;
use Yii;
use yii\helpers\Html;

/**
 * Class PublicController
 * @package app\controllers\base
 *
 * @property \app\models\SystemStructure $structure
 */
class PublicController extends CommonController
{
    public $doPageController = false;
    public static $controllerTitle = false;
    public $seo = [
        'seo_title' => '',
        'seo_keywords' => '',
        'seo_description' => '',
        'og_title' => '',
        'og_description' => '',
        'og_image' => '',
    ];
    public $breadcrumbs = [];
    public $h1title = '';
    public $structure = false;
    public static $viewRoot = '';

    public $body_class = 'main-page';
    public $main_class = 'main-page';

    public static function getTitle() {
        return static::$controllerTitle;
    }

    public static function getRules($type = false)
    {
        return [];
    }

    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        $thisController = preg_replace(['/^app\\\\controllers\\\\/', '/Controller$/'], ['', ''], get_class($this));
        $this->structure = SystemStructure::find()->where(['controller' => $thisController])->one();
        if ($this->structure) $this->setPageParams($this->structure, false, 'h1_title');

        $this->breadcrumbs = MenuHelper::breadcrumbs();
        array_unshift($this->breadcrumbs, [
            'label' => 'Главная',
            'url' => '/',
        ]);

        return parent::beforeAction($action);
    }

    public function renderContent($content)
    {
        $additional = '';
        if ($this->doPageController) $additional = Yii::$app->runAction('page/afterpage', ['handle' => preg_replace('/^\//', '', current(explode('?', Yii::$app->request->url)))]);

        return parent::renderContent($content . $additional);
    }

    /**
     * @param $tree CActiveQueryTree
     */
    public function addToBreadcrumbTree($tree, $titleattribute = 'title', $urlattribute = 'selfUrl') {
        $breadcrumbs = [];

        while ($tree->depth != 0) {
            $breadcrumbs[] = [
                'label' => $tree->{$titleattribute},
                'url' => $tree->{$urlattribute},
            ];
            $tree = $tree->parents(1)->one();
        }

        $breadcrumbs = array_reverse($breadcrumbs);
        $this->breadcrumbs = array_merge($this->breadcrumbs, $breadcrumbs);
    }

    public function setPageParams($item, $bc = true, $h1attribute = 'title', $urlattribute = 'selfUrl') {
        if ($bc) {
            $this->breadcrumbs[] = [
                'label' => $item->{$h1attribute},
                'url' => $item->{$urlattribute},
            ];
        }

        $this->seo['seo_title'] = $item->{$h1attribute};
        $this->seo['og_title'] = $item->{$h1attribute};
        if (!empty($item->seo_title)) $this->seo['seo_title'] = $item->seo_title;
        if (!empty($item->seo_keywords)) $this->seo['seo_keywords'] = $item->seo_keywords;
        if (!empty($item->seo_description)) $this->seo['seo_description'] = $item->seo_description;
        if (!empty($item->og_title)) $this->seo['og_title'] = $item->og_title;
        if (!empty($item->og_description)) $this->seo['og_description'] = $item->og_description;
        if (!empty($item->og_image)) $this->seo['og_image'] = $item->og_image;

        $this->h1title = $item->{$h1attribute};
        if (empty($this->h1title) && !empty($this->seo[$h1attribute])) $this->h1title = $this->seo[$h1attribute];
    }

    public function head() {
        echo '<link rel="icon" href="/assets/front/img/favicon.ico">';
        echo '<link rel="icon" href="/assets/front/img/favicon.svg" type="image/svg+xml">';
        echo '<link rel="apple-touch-icon" href="/assets/front/img/favicon.png">';

        echo '<meta name="keywords" content="' . $this->seo['seo_keywords'] . '">' . "\r\n";
        echo '<meta name="description" content="' . $this->seo['seo_description'] . '">' . "\r\n";
        echo '<meta property="og:title" content="' . $this->seo['og_title'] . '" />' . "\r\n";
        echo '<meta property="og:description" content="' . $this->seo['og_description'] . '" />' . "\r\n";
        echo '<meta property="og:image" content="' . SystemSettings::getParam('adminbase', 'site_url').$this->seo['og_image'] . '" />' . "\r\n";
        echo '<meta property="og:url" content="'.SystemSettings::getParam('adminbase', 'site_url').SystemHelper::LanguageLink(Yii::$app->request->url).'" />' . "\r\n";
        echo '<meta property="og:type" content="website" />' . "\r\n";

        echo '<base href="' . Yii::$app->request->url . '" />' . "\r\n";

        echo Html::csrfMetaTags();
        echo SystemSettings::getParam('adminbase', 'headEnd');
    }

    public function beginBody() {
        echo SystemSettings::getParam('adminbase', 'bodyBegin');
    }

    public function endBody() {
        echo SystemSettings::getParam('adminbase', 'bodyEnd');
    }

    public function render($view, $params = [])
    {
        $res = parent::render(static::$viewRoot . $view, $params);

        $res = str_replace(['[[', ']]'], ['<span class="accent">', '</span>'], $res);

        return $res;
    }

    /**
     * @param $controller SitemapController
     */
    public static function sitemap($controller) {

    }
}