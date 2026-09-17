<?php

namespace app\components\sms;

use Yii;

class SmsSenderDigitalDirect extends SmsSender {
    public static $url = 'https://direct.i-dgtl.ru/api';

    public static function send($from, $to, $message)
    {
        parent::send($from, $to, $message);
        if (empty(Yii::$app->params['sms']['digital_direct']['enable'])) return true;

        $params = [[
            'channelType' => 'SMS',
            'senderName' => $from,
            'destination' => static::tel($to),
            'content' => $message,
        ]];

        $result = static::sending(static::$url.'/v1/message', Yii::$app->params['sms']['digital_direct']['key'], $params);
        $result_json = json_decode($result, true);

        return empty($result_json['error']);
    }

    public static function tel($phone) {
        return preg_replace('/^[87]/', '7', preg_replace('/[^0-9]+/', '', $phone));
    }

    public static function sending($host, $key, $data) {
        $headers = array(
            'Content-type: application/json',
            'Authorization: Basic '. $key,
        );

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);

        //$info = curl_getinfo($ch);
        //echo '<pre>' . print_r($info, true) . '</pre>' . "\n";

        curl_close($ch);

        return $return;
    }
}