<?php
namespace app\components;

use alente\adminbase\models\SystemSettings;
use app\models\CardPayment;
use Yii;

class Sber
{
    const URLS = [
        'debug' => [
            'register' => 'https://3dsec.sberbank.ru/payment/rest/register.do',
            'getOrderStatusExtended' => 'https://3dsec.sberbank.ru/payment/rest/getOrderStatusExtended.do',
            'getOrderStatus' => 'https://3dsec.sberbank.ru/payment/rest/getOrderStatus.do',
        ],
        'prod' => [
            'register' => 'https://securepayments.sberbank.ru/payment/rest/register.do',
            'getOrderStatusExtended' => 'https://securepayments.sberbank.ru/payment/rest/getOrderStatusExtended.do',
            'getOrderStatus' => 'https://securepayments.sberbank.ru/payment/rest/getOrderStatus.do',
        ],
    ];

    const ORDER_STATUS_REGISTERED = 0; // Заказ зарегистрирован, но не оплачен
    const ORDER_STATUS_HOLDED = 1; // Предавторизованная сумма захолдирована
    const ORDER_STATUS_PAYED = 2; // Проведена полная авторизация суммы заказа
    const ORDER_STATUS_CANCELED = 3; // Авторизация отменена
    const ORDER_STATUS_REFUND = 4; // По транзакции была проведена операция возврата
    const ORDER_STATUS_EMITTED = 5; // Инициирована авторизация через ACS банка-эмитента
    const ORDER_STATUS_REJECTED = 6; // Авторизация отклонена

    public static function registerOrder($order_id, $items, $amount = 0, $backurl = false) {
        if (!empty(Yii::$app->params['sber']['enable'])) {
            /*$items = [];
            foreach ($card_payment->items as $item) {
                $items[] = [
                    'positionId' => $item->id,
                    'name' => $item->title,
                    'quantity' => [
                        'value' => $item->quantity,
                        'measure' => empty($item->unit)?'шт':$item->unit,
                    ],
                    'itemCode' => !empty($item->good_id) ? $item->good_id : ('v_' . $item->id),
                    'itemPrice' => ($item->price * 100) / $item->quantity,
                ];
            }*/

            if (!empty($items)) {
                $amount = 0;
                foreach ($items as $k => $item) {
                    $amount += $item['itemPrice'] * $item['quantity']['value'];
                }
            }

            $params = array(
                'userName' => Yii::$app->params['sber']['login'],
                'password' => Yii::$app->params['sber']['password'],
                'orderNumber' => $order_id . (Yii::$app->params['sber']['debug']?'_debug':''),
                'amount' => $amount,
                'sessionTimeoutSecs' => 3600 * 5,
            );
            if (!empty($backurl)) {
                $params['returnUrl'] = $backurl;
                $params['failUrl'] = $backurl;
            }
            if (!empty($items)) $params['orderBundle'] = json_encode(['cartItems' => ['items' => $items]]);

            $response = static::request(static::URLS[Yii::$app->params['sber']['debug']?'debug':'prod']['register'], $params);
            if (!empty($response)) {
                $response = json_decode($response, true);

                return $response;
            }

            return $response;
        }

        return false;
    }

    public static function checkOrder($payment_system_id) {
        if (!empty(Yii::$app->params['sber']['enable'])) {
            $params = array(
                'userName' => Yii::$app->params['sber']['login'],
                'password' => Yii::$app->params['sber']['password'],
                'orderId' => $payment_system_id,
            );

            $response = static::request(static::URLS[Yii::$app->params['sber']['debug']?'debug':'prod']['getOrderStatus'], $params);
            if (!empty($response)) {
                $response = json_decode($response, true);

                return $response;
            }

            return $response;
        }

        return false;
    }

    public static function request($url, $post_data) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

}