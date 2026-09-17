<?php

namespace app\jobs;

use app\models\SystemUser;
use app\models\SystemUserConfirm;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class UserConfirmClearingJob extends BaseObject implements JobInterface
{
    public $confirm_id;

    public function execute($queue)
    {
        $confirm = SystemUserConfirm::findOne($this->confirm_id);
        if ($confirm) {
            $confirm->delete();
        }
    }
}