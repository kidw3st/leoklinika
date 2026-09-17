<?php

namespace app\controllers\admin;

use alente\kitum\helpers\GeneratorHelper;
use app\controllers\base\AdminController;
use Yii;

class DashboardController extends AdminController
{
    public $layout = '@app/views/admin/layouts/main';

    public function actionIndex()
    {
        return $this->render('//admin/dashboard/index');
    }

    public function actionGii() {
        return $this->render('gii', [
            'createdTables' => GeneratorHelper::getModels(),
            'controllers' => GeneratorHelper::getObjects('controllers'),
            'settings' => GeneratorHelper::getObjects('settings'),
        ]);
    }

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception->statusCode == 403) {
            $this->layout = '@app/views/admin/layouts/empty';

            return $this->render('auth_error', ['exception' => $exception]);
        }

        return $this->render('error', ['exception' => $exception]);
    }
}