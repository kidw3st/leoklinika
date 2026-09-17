<?php 
namespace app\controllers;

use app\controllers\base\PublicController;
use Yii;

class SiteController extends PublicController
{
    public $doPageController = false;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/',
                'route' => 'site/index',
            ],
        ];
    }

    public static $controllerTitle = 'Главная';

    public function actionIndex() {
        return $this->render('index', [
        ]);
    }

    public function actionError() {
        $this->layout = 'main';
        $this->body_class = '404 page';
        $this->main_class = 'main container';
        $this->h1title = 'Ошибка';
        $this->seo['seo_title'] = 'Ошибка';
        $template = 'error';

        $exception = Yii::$app->errorHandler->exception;

        $error_title = 'Cтраница не найдена';
        $error_text = 'Кажется, вы не туда попали! Давайте убедимся, что вы на верном пути.';

        if (Yii::$app->response->statusCode == 500) {
            $error_title = 'Страница недоступна';
            $error_text = 'Упс! Страница утеряна. Мы уже устраняем эту проблему.';
            $template = 'error_500';
            $this->body_class = '500 page';
        }

        return $this->render($template, ['exception' => $exception, 'error_title' => $error_title, 'error_text' => $error_text]);
    }

    public static function sitemap($controller) {
        //$controller->addArray('site/index', [], date('c'), 'monthly', '1');
    }
}