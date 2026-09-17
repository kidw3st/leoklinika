<?php

namespace app\components\base;

use Yii;
use yii\web\NotFoundHttpException;

class Pagination extends \yii\data\Pagination {
    public $maxPage;

    public static function getPages($cnt, $size, $route, $params, $page, $pageParam = 'page', $use_canonical = false) {
        unset($params[$pageParam]);
        $pages = new Pagination(['totalCount' => $cnt]);
        $pages->pageSize = $size;
        $pages->route = $route;
        $pages->params = $params;
        $pages->page = $page;
        $pages->pageParam = $pageParam;

        $pages->calculate();
        if ($pages->maxPage <= $page && $pages->maxPage != 0) throw new NotFoundHttpException();

        if ($use_canonical && $page > 0) {
            Yii::$app->view->registerLinkTag([
                'rel' => 'canonical',
                'href' => $pages->getUrl(1),
            ]);
        }

        return $pages;
    }
    
    public function calculate() {
        $this->maxPage = intval($this->totalCount / $this->pageSize) + (($this->totalCount % $this->pageSize==0)?0:1);
    }
    
    public function draw($template = '//layouts/_pager', $itemsCount = 2, $options = []) {
        $pages = $this;
        $maxPage = $this->maxPage;
        $currentPage = $this->page + 1;
        $startPage = $currentPage - $itemsCount; if($startPage < 1) $startPage = 1;
        $endPage = $startPage + $itemsCount * 2; if($endPage > $maxPage) $endPage = $maxPage;
        $startPage = $endPage - $itemsCount * 2; if($startPage < 1) $startPage = 1;
        $this->params = is_array($this->params)?$this->params:[];

        $firstPageUrl = \Yii::$app->urlManager->createUrl(array_merge([$this->route], $this->params));
        $endPageUrl = \Yii::$app->urlManager->createUrl(array_merge([$this->route], $this->params, [$this->pageParam => $maxPage]));
        if ($currentPage > 1)
            $previousUrl = \Yii::$app->urlManager->createUrl(array_merge([$this->route], $this->params, [$this->pageParam => $currentPage - 1]));
        else
            $previousUrl = false;

        if ($currentPage < $maxPage)
            $nextUrl = \Yii::$app->urlManager->createUrl(array_merge([$this->route], $this->params, [$this->pageParam => $currentPage + 1]));
        else
            $nextUrl = false;
        
        $nextPageItemCount = $pages->totalCount - $currentPage * $pages->pageSize;
        if ($nextPageItemCount > $pages->pageSize) $nextPageItemCount = $pages->pageSize;

        $showedCnt = $this->pageSize * ($this->page + 1);
        if ($currentPage >= $maxPage) $showedCnt = $this->totalCount;

        return Yii::$app->view->render($template, compact(
            'pages', 'maxPage', 'currentPage', 'startPage', 'endPage', 'firstPageUrl', 'endPageUrl', 'previousUrl', 'nextUrl', 'nextPageItemCount', 'showedCnt', 'options'
        ));
    }

    public function getUrl($page) {
        if ($page == 1) {
            return Yii::$app->urlManager->createUrl(array_merge([$this->route], $this->params));
        }
        return Yii::$app->urlManager->createUrl(array_merge([$this->route], $this->params, [$this->pageParam => $page]));
    }
}