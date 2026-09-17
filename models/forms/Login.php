<?php
namespace app\models\forms;

use app\components\base\CModel;
use app\components\recaptcha\Recaptcha;
use app\models\SystemSettings;
use app\models\SystemUser;
use Yii;

class Login extends CModel
{
    public $login;
    public $password;

    public $form_handle = false;

    public function attributeLabels()
    {
        $res = [
            'login' => 'email / телефон',
            'password' => 'Пароль',
        ];

        if ($this->form_handle) {
            $settings = SystemSettings::find()->where(['module' => 'form_'.$this->form_handle])->indexBy('code')->all();
            foreach ($res as $k => $val) {
                if (!empty($settings[$k])) {
                    $res[$k] = $settings[$k]->value;
                }
            }
        }

        return $res;
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function beforeValidate()
    {
        $res = parent::beforeValidate();

        if ($res) $res = Recaptcha::check($this);

        return $res;
    }

    public function login() {
        $user = SystemUser::find()
            ->where(['OR', ['login_username' => $this->login], ['login_email' => $this->login], ['login_phone' => SystemUser::phone2db($this->login)]])
            ->andWhere(['<>', 'status', 0])->one();

        if ($user && $user->password == SystemUser::generatePassword($this->password)) {
            if ($user->status == 2) {
                return $user;
            } else {
                $this->addError('', SystemSettings::getParam('mail', 'validator_login_access_denied', 'Пользователю запрещен вход'));
            }
        } else {
            $this->addError('', SystemSettings::getParam('mail', 'validator_login_user_not_found', 'Пользователь не найден или пароль не совпадает'));
        }

        return false;
    }
}