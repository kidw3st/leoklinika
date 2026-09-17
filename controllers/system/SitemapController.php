<?php

namespace app\controllers\system;

use app\controllers\base\PublicController;
use app\helpers\base\SystemHelper;
use Yii;
use yii\helpers\BaseUrl;
use yii\web\NotFoundHttpException;

class SitemapController extends PublicController {
    private $sitemap;
    private $baseurl;
    private $basedate;
    public static $maxUrls = 1000;
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($page = 0)
    {
        $this->baseurl = BaseUrl::base(true);
        $this->basedate = date('c');
        $this->sitemap = array();
        //--------------------------------------------------------

        $controller_dir = Yii::getAlias('@app/controllers');
        $dirsToResearch = [$controller_dir];

        while (count($dirsToResearch) > 0) {
            $current_dir = array_shift($dirsToResearch);
            if (file_exists($current_dir)) {
                $controllers = scandir($current_dir);

                foreach ($controllers as $controller) {
                    if ($controller != '.' && $controller != '..' && $controller != 'admin') {
                        if (!is_dir($current_dir . '/' . $controller)) {
                            $controllerFullName = 'app\\controllers' .
                                str_replace(
                                    [$controller_dir, '/'],
                                    ['', '\\'],
                                    $current_dir
                                ) . '\\' .
                                str_replace('.php', '', $controller);
                            $controllerName = str_replace(
                                [$controller_dir . '/', $controller_dir . '\\', $controller_dir, '/'],
                                ['', '', '', '\\'],
                                $current_dir
                            );
                            $controllerName = (!empty($controllerName) ? $controllerName . '\\' : '') . str_replace('Controller.php', '', $controller);

                            if (method_exists($controllerFullName, 'sitemap')) {
                                $controllerFullName::sitemap($this);
                            }
                        } else {
                            $dirsToResearch[] = $current_dir . '/' . $controller;
                        }
                    }
                }
            }
        }

        //--------------------------------------------------------

        $this->sitemap = array_values($this->sitemap);

        $pages = ceil(count($this->sitemap) / static::$maxUrls);
        if ($page > $pages || $page == 1 && $pages == 1) throw new NotFoundHttpException();

        $this->layout = false;
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        header("Content-Type: text/xml");
        header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: post-check=0,pre-check=0");
        header("Cache-Control: max-age=0");
        header("Pragma: no-cache");

        return $this->render('index', [
            'pages' => $pages,
            'page' => $page,
            'maxUrls' => static::$maxUrls,
            'sitemap' => $this->sitemap,
        ]);
    }

    public function addArray($temp, $tempArr, $lastmode, $changereq, $priority) {
        $url = Yii::$app->urlManager->createAbsoluteUrl([$temp] + $tempArr);
        $this->sitemap[$url] = array(
            'loc' => $url,
            'lastmod' => (($lastmode==false)?$this->basedate:$lastmode),
            'changefreq' => $changereq,
            'priority' => $priority,
        );
    }

    public function addArrayFull($url, $lastmode, $changereq, $priority) {
        $url = $this->baseurl.$url;
        if ($lastmode == false) $lastmode = $this->basedate;
        if ($lastmode == date('c', 0)) $lastmode = $this->basedate;
        $this->sitemap[$url] = array(
            'loc' => $url,
            'lastmod' => $lastmode,
            'changefreq' => $changereq,
            'priority' => $priority,
        );
    }

    public function countPages($all, $onPage) {
        if ($onPage == '' || $onPage < 1) $onPage = 10;
        return ceil($all / $onPage);
    }
}