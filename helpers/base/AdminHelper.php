<?php

namespace app\helpers\base;

use Yii;
use yii\helpers\Html;

class AdminHelper {
    public static function getModels() {
        $result = [];

        $dir = Yii::getAlias('@app/models/parents');
        if (file_exists($dir)) {
            $dirs = scandir($dir);
            $dirs = array_diff($dirs, ['.', '..']);

            foreach($dirs as $file) {
                if (preg_match('/(.*)\.php$/', $file, $m)) {
                    $cn = '\\app\\models\\parents\\'.$m[1];
                    $cnChild = '\\app\\models\\'.preg_replace('/Parent$/', '', $m[1]);
                    $options = $cn::getOptions();

                    $f = fopen(Yii::getAlias('@app/models/parents/') . $file, "r");
                    $str1 = fgets($f);
                    $str2 = fgets($f);
                    fclose($f);

                    $post = [];
                    if (preg_match('/\<\?php\s+\/\//', $str1)) {
                        $post = unserialize(base64_decode(str_replace('<?php //', '', $str1)));
                    }
                    $migration = [];
                    if (preg_match('/\/\//', $str2)) {
                        $migration = unserialize(base64_decode(str_replace('//', '', $str2)));
                    }

                    $result[] = [
                        'class' => $cn,
                        'classChild' => $cnChild,
                        'label' => $cn::getLabel() . ' (' . preg_replace('/Parent$/', '', $m[1]) . ')',
                        'post' => $post,
                        'migration' => $migration,
                    ];
                }
            }
        }

        return $result;
    }

    public static function getSettings() {
        $result = [];

        $dir = Yii::getAlias('@app/models');
        if (file_exists($dir)) {
            $dirs = scandir($dir);
            $dirs = array_diff($dirs, ['.', '..']);

            foreach($dirs as $file) {
                $m = false;
                if (preg_match('/^(SystemSettings.+)\.php/', $file, $m)) {
                    $cn = '\app\models\\'.$m[1];

                    $result[$cn] = $cn::getLabel() . ' (' . preg_replace('/Parent$/', '', $m[1]) . ')';
                }
            }
        }

        return $result;
    }

    /*public static function getModels() {
        $result = [];

        $gii_path = Yii::getAlias('@app/gii_config.json');
        $gii_config = [];
        if (file_exists($gii_path)) $gii_config = json_decode(file_get_contents($gii_path), true);

        foreach ($gii_config['models'] as $modelClass => $model) {
            $result[] = [
                'class' => 'app\\models\\parents\\' . $modelClass.'Parent',
                'classChild' => 'app\\models\\' . $modelClass,
                'label' => $model['post']['modelLabel'] . ' (' . $modelClass . ')',
                'post' => $model['post'],
                'migration' => $model['db'],
            ];
        }

        return $result;
    }*/
}