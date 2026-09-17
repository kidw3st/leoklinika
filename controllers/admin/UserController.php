<?php
namespace app\controllers\admin;

use app\components\base\SocAuth;
use app\controllers\base\AdminController;
use app\models\forms\AdminLogin;
use app\models\SystemUser;
use app\models\SystemUserSocial;

use Yii;

class UserController extends AdminController
{
    public function behaviors()
    {
        $res = parent::behaviors();

        $res['access']['rules'][] = [
            'allow' => true,
        ];

        return $res;
    }

    public function actionLogin($backurl = '/') {
        $this->layout = '@app/views/admin/layouts/empty';
        $this->view->title = 'Вход в админку';

        if (!\Yii::$app->user->isGuest) {
            return $this->redirect($backurl);
        }

        $model = new AdminLogin();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($backurl);
        }
        return $this->render('login', ['model' => $model, 'backurl' => $backurl]);
    }

    public function actionLogout($backurl = '/')
    {
        Yii::$app->user->logout();
        return $this->redirect($backurl);
    }

    public function actionSoclogin($backurl = '/') {
        SocAuth::authorize(function($attributes) {
            if (!empty($attributes)) {
                $soc = SystemUserSocial::find()->where(['soc_name' => $attributes['network'], 'soc_id' => $attributes['uid']])->one();
                if (!$soc) {
                    $soc = new SystemUserSocial();
                    $soc->soc_name = $attributes['network'];
                    $soc->soc_id = $attributes['uid'];
                    $soc->data_obj = $attributes;
                }

                if (Yii::$app->user->isGuest) {
                    if ($soc->isNewRecord) {
                        $user = SystemUser::find()->where(['login_email' => $attributes['email']])->one();
                    } else {
                        $user = $soc->user;
                    }
                    if (!$user) {
                        $user = new SystemUser();
                        $user->login_email = $attributes['email'];
                        $user->password_input = substr(md5(time()), 5, 10);
                        //$user->email = $attributes['email'];
                        $user->status = 2;
                        $user->name = $attributes['first_name'];
                        $user->surname = $attributes['last_name'];
                    }

                    if ($user->image == '') {
                        //$user->setFile('image', $attributes['photo_big']);
                    }

                    if ($user->save()) {
                        $soc->user_id = $user->id;
                        $soc->save();

                        Yii::$app->user->login($user);
                    }
                } else {
                    $soc->user_id = Yii::$app->user->id;
                    $soc->save();
                }
            }
        });

        return $this->redirect($backurl);
    }
}