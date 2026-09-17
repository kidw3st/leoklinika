<?php

namespace app\helpers\base;

use Yii;

class SberHelper
{
    const URLS = [
        'debug' => [
            'register' => 'https://3dsec.sberbank.ru/payment/rest/register.do',
            'getOrderStatus' => 'https://3dsec.sberbank.ru/payment/rest/getOrderStatus.do',
        ],
        'prod' => [
            'register' => 'https://securepayments.sberbank.ru/payment/rest/register.do',
            'getOrderStatus' => 'https://securepayments.sberbank.ru/payment/rest/getOrderStatus.do',
        ],
    ];

    public static function verboseOrderStatus($stat){
        $orderStatus = [
            0 => 'Заказ зарегистрирован, но не оплачен',
            1 => 'Предавторизованная сумма захолдирована',
            2 => 'Проведена полная авторизация суммы заказа',
            3 => 'Авторизация отменена',
            4 => 'По транзакции была проведена операция возврата',
            5 => 'Инициирована авторизация через ACS банка-эмитента',
            6 => 'Авторизация отклонена'
        ];
        if(isset($orderStatus[$stat]))
            return $orderStatus[$stat];

        return '';
    }

    public static function registerOrder($oid, $items, $summa, $backurl) {
        if (empty(Yii::$app->params['sberbank']['login'])) return [];

        $orderBundle = [];
        $orderItems = [];

        foreach ($items as $k => $item) {
            $orderItems[] = [
                'positionId' => $k+1,
                'name' => $item['title'],
                'quantity' => [
                    'value' => $item['count'],
                    'measure' => 'Шт',
                ],
                'itemCode' => $item['code'],
                'itemPrice' => $item['price'] * 100,
            ];
        }

        if (!empty($orderItems)) {
            $orderBundle = [
                'cartItems' => [
                    'items' => $orderItems,
                ]
            ];
        }

        $params = array(
            'userName' => Yii::$app->params['sberbank']['login'],
            'password' => Yii::$app->params['sberbank']['password'],
            'orderNumber' => $oid.(Yii::$app->params['sberbank']['debug']?'_dev':''),
            'amount' => ($summa*100),
            //'sessionTimeoutSecs' => 60,
            'returnUrl' => $backurl,
            'failUrl' => $backurl,
        );
        if (!empty($orderBundle)) {
            $params['orderBundle'] = (json_encode($orderBundle,JSON_UNESCAPED_UNICODE));
        }

        $response = SberHelper::post_send(SberHelper::URLS[Yii::$app->params['sberbank']['debug']?'debug':'prod']['register'], $params);
        if (!empty($response)) {
            return [
                'request' => $params,
                'response' => json_decode($response, true)
            ];
        }

        return [
            'request' => $params,
            'response' => [],
        ];
    }

    public static function getStatusOrder($oid) {
        if (empty(Yii::$app->params['sberbank']['login'])) return [];

        $params = array(
            'userName' => Yii::$app->params['sberbank']['login'],
            'password' => Yii::$app->params['sberbank']['password'],
            'orderId' => $oid,
        );

        $response = SberHelper::post_send(SberHelper::URLS[Yii::$app->params['sberbank']['debug']?'debug':'prod']['getOrderStatus'], $params);
        if (!empty($response)) {
            return json_decode($response, true);
        }

        return [];
    }

    public static function post_send($url, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);

        return $response;
    }
}