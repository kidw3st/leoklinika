<?php
namespace app\models;

use app\helpers\base\UserHelper;
use Yii;
use app\models\parents\FilialParent;
use yii\helpers\Url;

/**
 * Class Filial
 * @package app\models
 *
 * @property string $title
 * @property string $status_code
 * @property string $status_text
 * @property array $phones_arr
 * @property array $emails_arr
 * @property string $full_title
 * @property string $changeUrl
 */
class Filial extends FilialParent
{
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'times_1' => 'Время работы (Пн)',
            'times_2' => 'Время работы (Вт)',
            'times_3' => 'Время работы (Ср)',
            'times_4' => 'Время работы (Чт)',
            'times_5' => 'Время работы (Пт)',
            'times_6' => 'Время работы (Сб)',
            'times_7' => 'Время работы (Вс)',
        ]);
    }
    
    public function rules()
    {
        $times = [];

        for ($i = 1; $i <= 7; $i++) {
            $times[] = [['times_'.$i.'_from', 'times_'.$i.'_to'], 'string'];
        }

        return array_merge(parent::rules(), $times, [

        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        for ($i = 1; $i <= 7; $i++) {
            $res['fields']['times_'.$i] = [
                'sort' => 40 + $i,
                'inserted' => true,
                'edited' => true,
                'type' => 'string',
                'editor' => 'times',
            ];
        }

        return $res;
    }

    public function __set($name, $value)
    {
        if (preg_match('/times\_([1-7])_(from|to)/', $name, $m)) {
            $times = $this->times_obj;
            $times[$m[1]][$m[2]] = $value;
            $this->times_obj = $times;

            return;
        }
        parent::__set($name, $value);
    }

    public function __get($name)
    {
        if (preg_match('/times\_([1-7])_(from|to)/', $name, $m)) {
            $times = $this->times_obj;
            if (!empty($times[$m[1]][$m[2]])) return $times[$m[1]][$m[2]];

            return '';
        }
        return parent::__get($name);
    }

    /**
     * @return Filial
     */
    public static function getCurrent() {
        UserHelper::init();
        $city_id = UserHelper::getParam('city', false);

        $filial = null;
        if ($city_id !== false) $filial = Filial::find()->where(['id' => $city_id])->one();
        if (empty($filial)) $filial = Filial::find()->orderBy('is_default DESC')->one();

        return $filial;
    }

    public function getFull_title() {
        $res = [];
        
        if (!empty($this->city)) $res[] = $this->city;
        if (!empty($this->address)) $res[] = $this->address;

        return implode(', ', $res);
    }

    public function getPhones_arr() {
        $phones = explode("\r\n", $this->phones);

        $res = [];
        foreach ($phones as $phone) {
            $phone = trim($phone);
            if (!empty($phone)) $res[] = $phone;
        }

        return $res;
    }

    public function getEmails_arr() {
        $emails = explode("\r\n", $this->emails);

        $res = [];
        foreach ($emails as $email) {
            $phone = trim($email);
            if (!empty($email)) $res[] = $email;
        }

        return $res;
    }

    public function getTimes_res() {
        $days = [
            1 => 'пн',
            2 => 'вт',
            3 => 'ср',
            4 => 'чт',
            5 => 'пт',
            6 => 'сб',
            7 => 'вс',
        ];

        $res = [];
        $last_time = '';
        $last_day = [];
        $weekends = [];
        foreach ($this->times_obj as $k => $times) {
            if (!empty($times['from']) || !empty($times['to'])) {
                $times = implode(' до ', $times);
            } else {
                $times = '';
                $weekends[] = $days[$k];
            }
            if ($last_time != $times) {
                if (!empty($last_day)) {
                    if (!empty($last_time)) {
                        if (count($last_day) == 1) {
                            $res[] = $last_day[0] . ': ' . $last_time;
                        } else {
                            $res[] = $last_day[0] . '-' . end($last_day) . ': ' . $last_time;
                        }
                    }

                    $last_day = [];
                    $last_time = '';
                }
            }

            $last_day[] = $days[$k];
            $last_time = $times;
        }

        if (!empty($last_day) && !empty($last_time)) {
            if (count($last_day) == 1) {
                $res[] = $last_day[0] . ': ' . $last_time;
            } else {
                $res[] = $last_day[0] . '-' . end($last_day) . ': ' . $last_time;
            }
        }

        if (!empty($weekends)) $res[] = implode(', ', $weekends) . ': выходной';

        return $res;
    }

    public function getStatus_code() {
        $week = date('w');
        if ($week == 0) $week = 7;

        /** @var FilialWorkday $work_time */
        $work_time = $this->getWorkdays()->where(['date' => date('Y-m-d')])->one();
        if ($work_time) {
            $start = strtotime(date('d.m.Y ' . $work_time->times_from));
            $end = strtotime(date('d.m.Y ' . $work_time->times_to));

            if ($start <= time() && time() <= $end) return 'open';
        }

        if (!empty($this->times_obj[$week]['from']) && !empty($this->times_obj[$week]['to'])) {
            $start = strtotime(date('d.m.Y ' . $this->times_obj[$week]['from']));
            $end = strtotime(date('d.m.Y ' . $this->times_obj[$week]['to']));

            if ($start <= time() && time() <= $end) return 'open';
        }

        return 'close';
    }

    public function getStatus_text() {
        $times = $this->times_obj;
        $holidays = SystemSettings::getParamArray('filial', 'holidays', []);
        $week = date('w');
        if ($week == 0) $week = 7;

        if ($this->status_code == 'open') {
            $work_time = $this->getWorkdays()->where(['date' => date('Y-m-d')])->one();
            if ($work_time) {
                return 'Закроется в ' . $work_time->times_to;
            }

            return 'Закроется в ' . $times[$week]['to'];
        } else {
            for ($i = 0; $i < 7; $i++) {
                $new_week = ($week + $i) % 7;
                if ($new_week == 0) $new_week = 7;

                /** @var FilialWorkday $work_time */
                $work_time = $this->getWorkdays()->where(['date' => date('Y-m-d', time() + 86400 * $i)])->one();
                if ($work_time) {
                    $times[$new_week]['from'] = $work_time->times_from;
                    $times[$new_week]['to'] = $work_time->times_to;
                }

                if (!empty($holidays) && in_array(date('d.m.Y', time() + 86400 * $i), $holidays) && !$work_time) {
                    continue;
                }

                if (!empty($times[$new_week]['from'])) {
                    $start = strtotime(date('d.m.Y ' . $times[$new_week]['from'], time() + 86400 * $i));

                    if ($start > time()) {
                        if ($i == 0) {
                            return 'Откроется сегодня в ' . $times[$new_week]['from'];
                        } elseif ($i == 1) {
                            return 'Откроется завтра в ' . $times[$new_week]['from'];
                        } else {
                            return 'Откроется ' . date('d.m', $start) . ' в ' . $times[$new_week]['from'];
                        }
                    }
                }
            }
        }

        return 'Закрыто';
    }

    public function getChangeUrl() {
        return Yii::$app->urlManager->createUrl(['api/change_city', 'id' => $this->id]);
    }
}