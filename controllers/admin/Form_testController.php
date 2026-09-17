<?php
namespace app\controllers\admin;

use app\controllers\base\AdminController;
use app\models\forms\RequestReviewForm;
use Yii;

class Form_testController extends AdminController
{
    public function actionReview() {
        $model = new RequestReviewForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $this->render('result', ['model' => $model]);
        }

        return $this->render('review', ['model' => $model]);
    }
}