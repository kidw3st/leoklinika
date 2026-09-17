<?php
namespace app\models\forms;

use app\components\base\CModel;
use app\components\recaptcha\Recaptcha;
use app\models\SystemUser;
use Yii;

class AdminLogin extends CModel
{
    public $login;
    public $password;
    public $remember = false;
    public $backurl;

    public function attributeLabels()
    {
        return [
            'login' => 'Ваша почта',
            'password' => 'Введите пароль',
            'remember' => 'Запомнить меня',
        ];
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login'], 'email'],
            [['remember'], 'boolean'],
        ];
    }

    public function beforeValidate()
    {
        $res = parent::beforeValidate();

        if ($res) $res = Recaptcha::check($this);

        return $res;
    }

    public function save() {
        $user = SystemUser::find()
            ->where(['OR', ['login_username' => $this->login], ['login_email' => $this->login], ['login_phone' => SystemUser::phone2db($this->login)]])
            ->andWhere(['<>', 'status', 0])->one();

        if ($user && $user->password == SystemUser::generatePassword($this->password)) {
            if ($user->status == 2) {
                Yii::$app->user->login($user, $this->remember?(30 * 86400):0);
                return true;
            } else {
                $this->addError('', 'Пользователю запрещен вход');
            }
        } else {
            $this->addError('', 'Пользователь не найден или пароль не совпадает');
        }

        return false;
    }
}