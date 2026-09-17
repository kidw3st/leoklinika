<?php

namespace app\components\base;

use Yii;

class Date {
    private $_date;
    private $_datesrc;

    private static $_months_1 = false;
    private static $_months = false;
    private static $_short_months = false;

    private static function months_1() {
        if (static::$_months_1 === false) {
            static::$_months_1 = [
                '[[1]]' => Yii::t('app', 'январь'),
                '[[2]]' => Yii::t('app', 'февраль'),
                '[[3]]' => Yii::t('app', 'март'),
                '[[4]]' => Yii::t('app', 'апрель'),
                '[[5]]' => Yii::t('app', 'май'),
                '[[6]]' => Yii::t('app', 'июнь'),
                '[[7]]' => Yii::t('app', 'июль'),
                '[[8]]' => Yii::t('app', 'август'),
                '[[9]]' => Yii::t('app', 'сентябрь'),
                '[[10]]' => Yii::t('app', 'октябрь'),
                '[[11]]' => Yii::t('app', 'ноябрь'),
                '[[12]]' => Yii::t('app', 'декабрь'),
            ];
        }

        return static::$_months_1;
    }

    private static function months() {
        if (static::$_months === false) {
            static::$_months = [
                '[1]' => Yii::t('app', 'января'),
                '[2]' => Yii::t('app', 'февраля'),
                '[3]' => Yii::t('app', 'марта'),
                '[4]' => Yii::t('app', 'апреля'),
                '[5]' => Yii::t('app', 'мая'),
                '[6]' => Yii::t('app', 'июня'),
                '[7]' => Yii::t('app', 'июля'),
                '[8]' => Yii::t('app', 'августа'),
                '[9]' => Yii::t('app', 'сентября'),
                '[10]' => Yii::t('app', 'октября'),
                '[11]' => Yii::t('app', 'ноября'),
                '[12]' => Yii::t('app', 'декабря'),
            ];
        }

        return static::$_months;
    }

    private static function short_months() {
        if (static::$_short_months === false) {
            static::$_short_months = [
                '{1}' => Yii::t('app', 'янв'),
                '{2}' => Yii::t('app', 'фев'),
                '{3}' => Yii::t('app', 'мар'),
                '{4}' => Yii::t('app', 'апр'),
                '{5}' => Yii::t('app', 'мая'),
                '{6}' => Yii::t('app', 'июн'),
                '{7}' => Yii::t('app', 'июл'),
                '{8}' => Yii::t('app', 'авг'),
                '{9}' => Yii::t('app', 'сен'),
                '{10}' => Yii::t('app', 'окт'),
                '{11}' => Yii::t('app', 'ноя'),
                '{12}' => Yii::t('app', 'дек'),
            ];
        }

        return static::$_short_months;
    }

    public function __construct($date)
    {
        $this->_datesrc = $date;
        $this->_date = strtotime($date);
    }

    public function __toString()
    {
        return $this->_datesrc;
    }

    public function format($template, $diff = false) {
        $res = date($template, $this->_date);

        if ($diff) {
            $res = date($template, strtotime($diff, $this->_date));
        }
        $res = str_replace(array_keys(static::months_1()), array_values(static::months_1()), $res);
        $res = str_replace(array_keys(static::months()), array_values(static::months()), $res);
        $res = str_replace(array_keys(static::short_months()), array_values(static::short_months()), $res);

        return $res;
    }

    public function interval($template, $timestamp = false) {
        if ($timestamp === false) $timestamp = time();
        $datetime1 = date_create($this->_datesrc);
        $datetime2 = date_create(date('Y-m-d H:i:s', $timestamp));
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($template);
    }

    public function timeLeft() {
        return time() - $this->_date;
    }

    public function timeStamp() {
        return $this->_date;
    }
}
