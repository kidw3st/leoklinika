<?php

namespace app\jobs;

use app\models\SystemUser;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class UserClearingJob extends BaseObject implements JobInterface
{
    public $user_id;

    public function execute($queue)
    {
        $user = SystemUser::findOne($this->user_id);
        if ($user && $user->status == 0) {
            $user->delete();
        }
    }
}