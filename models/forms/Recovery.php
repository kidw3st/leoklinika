<?php
namespace app\models\forms;

use app\components\base\CModel;
use app\components\recaptcha\Recaptcha;
use app\models\SystemSettings;
use app\models\SystemUser;
use app\models\SystemUserConfirm;

class Recovery extends CModel
{
    public $login;
    public $type = 'email';

    public $form_handle = false;

    public function attributeLabels()
    {
        $res = [
            'login' => 'email / телефон',
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
            [['login'], 'required'],
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

        if ($user) {
            if ($user->status == 2) {
                $confirm_type = SystemUserConfirm::PASS_RECOVERY;
                if (!empty($user->login_phone) && $user->login_phone == SystemUser::phone2db($this->login)) {
                    $this->type = 'phone';
                    $confirm_type = SystemUserConfirm::PASS_RECOVERY_PHONE;
                }

                $time_left = 1000000;
                $confirm = SystemUserConfirm::find()->where(['user_id' => $user->id, 'type' => $confirm_type])->one();
                if ($confirm) $time_left = $confirm->created_at_obj->timeLeft();
                if ($time_left > 300) {
                    $confirm = new SystemUserConfirm(['user_id' => $user->id, 'type' => $confirm_type]);

                    $confirm->save();
                }

                return true;
            } else {
                $this->addError('', 'Пользователю запрещен вход');
            }
        } else {
            $this->addError('', 'Пользователь не найден');
        }

        return false;
    }
}