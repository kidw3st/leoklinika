<?php

namespace app\controllers\admin;

use app\controllers\base\AdminController;

class FilesController extends AdminController
{
    public function actionIndex($parent = false)
    {
        return $this->render('index');
    }
}