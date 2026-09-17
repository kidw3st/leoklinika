<?php

namespace app\widgets\login;

use app\models\SystemUser;
use Yii;

class LoginWidget extends \yii\base\Widget {
    public $options;
    public $template = false;
    public $id;
    public $backurl;

    public function init()
    {
        if ($this->template === false) $this->template = 'login';

        parent::init();
    }

    public function run()
    {
        $backurl = $this->backurl?$this->backurl:(Yii::$app->request->post('backurl', '/'));
        $classname = Yii::$app->user->identityClass;
        /** @var SystemUser $model */
        $model = new $classname;
        $model->scenario = 'login';
        $model->formNameSuffix = $this->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
         //   Yii::$app->response->redirect($backurl);
          //  Yii::$app->end();
        }

        return $this->render($this->template, ['model' => $model, 'backurl' => $backurl, 'id' => $this->id]);
    }
}