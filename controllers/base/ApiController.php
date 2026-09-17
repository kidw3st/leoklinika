<?php

namespace app\controllers\base;

use app\helpers\base\SeoHelper;
use app\models\PageMeta;
use Yii;
use yii\data\Pagination;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class ApiController extends Controller {
    public function init()
    {
        Yii::$app->user->enableSession = false;

        parent::init();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        //if ($this->need_auth)
            unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        //if ($this->need_auth) {
            $optional = [];
            $methods = get_class_methods($this);

            foreach ($methods as $method) {
                if (strpos($method, 'action') === 0 && $method !== 'actions') {
                    $method_name = strtolower(preg_replace('/^action/', '', $method));

                    $optional[] = $method_name;
                }
            }

            $behaviors['authenticator'] = [
                'class' => HttpBearerAuth::class,
                'optional' => $optional,
                'except' => ['options'],
            ];
        //}

        return $behaviors;
    }

    public function getParam($param, $default = false, $show_404_on_default = false) {
        $res = Yii::$app->request->post($param, Yii::$app->request->get($param, $default));
        if ($show_404_on_default && $res === $default) throw new NotFoundHttpException();

        return $res;
    }

    public function getPages($criteria, $page, $page_size, $not_found_exception = true) {
        $clone_criteria = clone $criteria;
        $all_elements = $clone_criteria->count();

        $pages = new Pagination(['totalCount' => $all_elements]);
        $pages->pageSize = $page_size;
        $pages->page = $page - 1;
        $maxPage = intval($pages->totalCount / $pages->pageSize) + (($pages->totalCount % $pages->pageSize==0)?0:1);

        $criteria->offset($pages->offset)->limit($pages->limit);

        $next = null;
        $prev = null;

        if ($page < ceil($pages->totalCount / $page_size)) $next = $page + 1;
        if ($page > 1) $prev = $page - 1;
        if ($not_found_exception && $page > 1 && $page > ceil($pages->totalCount / $page_size)) throw new NotFoundHttpException();

        $res = [
            'all_pages' => $maxPage,
            'all_elements' => (int)$all_elements,
            'page_size' => $page_size,
            'next' => $next,
            'prev' => $prev,
        ];

        return $res;
    }

    public function getMeta($handle) {
        $res = [
            'title' => '',
            'seo' => false,
        ];
        $meta = PageMeta::find()->where(['handle' => $handle])->one();

        if (!$meta) {
            $meta = new PageMeta(['title' => $handle, 'handle' => $handle]);
            $meta->save();
        }

        if($meta) {
            $res['title'] = $meta->title;
            $res['seo'] = SeoHelper::getSeoFields($meta);
        }

        return $res;
    }

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
}