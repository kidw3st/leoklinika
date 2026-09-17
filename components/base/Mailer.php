<?php

namespace app\components\base;

use app\models\EmailStack;

class Mailer extends \yii\swiftmailer\Mailer {
    public function send($message, $priority = 5)
    {
        $email = new EmailStack();
        $email->title = $message->getSubject();
        $email->to = json_encode($message->getTo());
        $email->from = json_encode($message->getFrom());
        $email->bcc = json_encode($message->getBcc());
        $email->text = $message->getSwiftMessage()->getBody();
        $email->priority = $priority;
        $email->status = '1';
        $email->save();

        return true;
    }
}