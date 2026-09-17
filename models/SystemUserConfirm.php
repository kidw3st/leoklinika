<?php
namespace app\models;

use app\helpers\base\SystemHelper;
use app\jobs\UserConfirmClearingJob;
use Yii;
use app\models\parents\SystemUserConfirmParent;

class SystemUserConfirm extends SystemUserConfirmParent
{
    public $set_update_time = false;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [

        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $confirm = SystemUserConfirm::find()->where(['user_id' => $this->user_id, 'type' => $this->type])->one();

            if ($confirm) {
                $this->code = $confirm->code;
                $confirm->delete();
            } else {
                $this->code = SystemHelper::getRandomCode(8);
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->queue->delay(30 * 60)->push(new UserConfirmClearingJob([
                'confirm_id' => $this->id,
            ]));

            SystemNoticeEvent::doEvent('user_confirm_' . $this->type, [
                'item' => $this,
            ]);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public static $eventCustomVariables = [
        'submitLink' => 'Ссылка на подтверждение',
    ];

    public function getSubmitLink() {
        return $this->backurl . '?' . http_build_query(['code' => $this->code]);
    }

    public function execute() {
        if ($this->type == 'register_email') {
            $this->user->status = 2;
            $this->user->login_email = $this->email;
            $this->user->save();
        }

        if ($this->type == 'register_phone') {
            $this->user->status = 2;
            $this->user->login_phone = $this->phone;
            $this->user->save();
        }
        if ($this->type == 'change_email') {
            $this->user->login_email = $this->email;
            $this->user->save();
        }

        if ($this->type == 'change_phone') {
            $this->user->login_phone = $this->phone;
            $this->user->save();
        }

        $this->delete();
    }

    public function timeout_delete() {
        $this->delete();
    }
}