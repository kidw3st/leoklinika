<?php
namespace app\models;

use Yii;
use app\models\parents\FilialWorkdayParent;

/**
 * Class FilialWorkday
 * @package app\models
 *
 * @property string $times_from
 * @property string $times_to
 */
class FilialWorkday extends FilialWorkdayParent
{
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['times_from', 'times_to'], 'string'],
        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        $res['fields']['times']['editor'] = 'times';

        return $res;
    }

    public function getTimes_from() {
        $times = explode(' - ', $this->times);
        if (!empty($times[0])) return trim($times[0]);

        return '';
    }

    public function getTimes_to() {
        $times = explode(' - ', $this->times);
        if (!empty($times[1])) return trim($times[1]);

        return '';
    }

    public function setTimes_from($value) {
        $times = explode(' - ', $this->times);
        $times[0] = $value;
        $this->times = implode(' - ', $times);
    }

    public function setTimes_to($value) {
        $times = explode(' - ', $this->times);
        $times[1] = $value;
        $this->times = implode(' - ', $times);
    }
}