<?php

namespace app\helpers\base;

use Exception;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;

class BImages {
    const PROPORTIAL = 1;
    const CROP = 2;
    const PROPORTIALWITHWHITE = 3;
    const CROPFULL = 4;

    public static function doProp($img, $w, $h, $q = 95) {
        return self::get_url($img, array('w' => $w, 'h' => $h, 't' => self::PROPORTIAL, 'q' => $q));
    }

    public static function doCrop($img, $w, $h, $q = 95) {
        return self::get_url($img, array('w' => $w, 'h' => $h, 't' => self::CROP, 'q' => $q));
    }

    public static function doPropW($img, $w, $h, $q = 95) {
        return self::get_url($img, array('w' => $w, 'h' => $h, 't' => self::PROPORTIALWITHWHITE, 'q' => $q));
    }

    public static function doCropFull($img, $w, $h, $q = 95) {
        return self::get_url($img, array('w' => $w, 'h' => $h, 't' => self::CROPFULL, 'q' => $q));
    }

    public static function get_url($img_src, $params) {
        $nopic = '/up/no-image.png';

        if ($img_src == '' || !file_exists(Yii::getAlias('@webroot') . $img_src) || is_dir(Yii::getAlias('@webroot') . $img_src)) $img_src = $nopic;
        if (preg_match('/\.svg$/', $img_src)) return $img_src;

        try {
            $image = Image::getImagine()->open(Yii::getAlias('@webroot') . $img_src);
        } catch (Exception $e) {
            $img_src = $nopic;
            $image = Image::getImagine()->open(Yii::getAlias('@webroot') . $img_src);
        }

        $boxSize = $image->getSize();

        if ($params['w'] >= $boxSize->getWidth() && $params['h'] >= $boxSize->getHeight()) {
            return $img_src;
        }

        $pi = SystemHelper::full_pathinfo($img_src);
        $tmpPath = '/up/resizetmp/' . $params['w'] . '_' . $params['h'] . '_' . $params['t'].'/'.md5(str_replace(Yii::getAlias('@webroot'), '', $pi['dirname']));
        $tmpFile = TextHelper::translit($pi['filename']).'.'.$pi['extension'];

        if (!file_exists(Yii::getAlias('@webroot') . $tmpPath . '/' . $tmpFile) || filemtime(Yii::getAlias('@webroot') . $tmpPath . '/' . $tmpFile) < filemtime(Yii::getAlias('@webroot') . $img_src)) {
            FileHelper::createDirectory(Yii::getAlias('@webroot') . $tmpPath);
            $proc1 = $params['w'] / $boxSize->getWidth();
            $proc2 = $params['h'] / $boxSize->getHeight();
            $proc_min = ($proc1 < $proc2?$proc1:$proc2);
            $proc_max = ($proc1 > $proc2?$proc1:$proc2);

            switch ($params['t']) {
                case self::PROPORTIAL:
                    $resizeBox = $boxSize->scale($proc_min);
                    $image->resize($resizeBox)->save(Yii::getAlias('@webroot') . $tmpPath . '/' . $tmpFile, ['quality' => $params['q']]);
                    break;
                case self::CROP:
                    $resizeBox = $boxSize->scale($proc_max);
                    $point = new Point(($resizeBox->getWidth() - $params['w']) / 2, ($resizeBox->getHeight() - $params['h']) / 2);
                    $image->resize($resizeBox)->crop($point, new Box($params['w'], $params['h']))->save(Yii::getAlias('@webroot') . $tmpPath . '/' . $tmpFile, ['quality' => $params['q']]);
                    break;
                case self::PROPORTIALWITHWHITE:
                    $resizeBox = $boxSize->scale($proc_min);
                    $image->resize($resizeBox)->save(Yii::getAlias('@webroot') . $tmpPath . '/' . $tmpFile, ['quality' => $params['q']]);
                    break;
                case self::CROPFULL:
                    $resizeBox = $boxSize->scale($proc_max);
                    $image->resize($resizeBox)->save(Yii::getAlias('@webroot') . $tmpPath . '/' . $tmpFile, ['quality' => $params['q']]);
                    break;
            }
        }

        return $tmpPath . '/' . $tmpFile;
    }
}