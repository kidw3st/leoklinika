<?php

namespace app\controllers\base;

use app\helpers\base\UserHelper;
use app\models\SystemAdminMenu;
use app\components\base\Menu;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends CommonController
{
    public $layout = '@app/views/admin/layouts/main';
    public $menu;
    public $breadcrumbs = [];

    public function init()
    {
        parent::init();

        Yii::$app->errorHandler->errorAction = 'admin/dashboard/error';

        Yii::$app->request->enableCsrfValidation = false;
        Yii::$app->user->loginUrl = [Yii::$app->urlManager->createUrl(['admin/user/login', 'backurl' => Yii::$app->request->url])];

        $this->breadcrumbs[] = [
            'label' => 'Главная',
            'url' => '/admin',
            'icon' => 'dashboard',
        ];

        $this->menu = new Menu(SystemAdminMenu::find()->roots()->one(), false, false, 'admin_menu');
        $this->menu->setActiveByRequestUrl();

        unset(Yii::$app->assetManager->bundles['yii\web\JqueryAsset']);
        /*Yii::$app->assetManager->bundles['yii\web\JqueryAsset']['sourcePath'] = '@app/assets/src';
        Yii::$app->assetManager->bundles['yii\web\JqueryAsset']['js'] = [
            'bower_components/jquery/dist/jquery.min.js'
        ];*/
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        //'roles' => [Admin::getInstance()->getPermissionNameByClass($this)],
                        'matchCallback' => function ($rule, $action) {
                            if ($action->uniqueId == 'admin/dashboard/error') return true;
                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->status == 2 && Yii::$app->user->identity->admin) return true;
                            return false;
                        }
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->request->get('lang_id', false)) {
            UserHelper::setParam('lang_id', Yii::$app->request->get('lang_id', false));
            UserHelper::update();

            return $this->redirect(Url::current(['lang_id' => null]));
        }

        return parent::beforeAction($action);
    }

    public function render($view, $params = [])
    {
        return parent::render($view, $params);
    }

    public function addBreadcrumb($label, $url = false, $icon = false) {
        $breadcrumb = ['label' => $label];
        if ($url) $breadcrumb['url'] = $url;
        if ($icon) $breadcrumb['icon'] = $icon;

        $this->breadcrumbs[] = $breadcrumb;
    }
}