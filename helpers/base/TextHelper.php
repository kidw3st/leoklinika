<?php

namespace app\helpers\base;

use DateTime;
use Yii;

class TextHelper {
    public static function drawTreeRaw($items, $titleAttribute = 'title', $liAttributesFunction = '', $liHtmlFunction = '') {
        $depth = -1;
        foreach($items as $item) {
            if ($depth < $item->depth) {
                echo '<ul>';
                $depth = $item->depth;
            } elseif($depth == $item->depth) {
                echo '</li>';
            } elseif($depth > $item->depth) {
                echo str_repeat('</li></ul>', $depth - $item->depth);
                echo '</li>';
                $depth = $item->depth;
            }

            $attr = '';
            $html = $item->$titleAttribute;

            if ($liAttributesFunction !== '') $attr = ' ' . $liAttributesFunction($item);
            if ($liHtmlFunction !== '') $html = $liHtmlFunction($item);

            echo '<li'.$attr.'>'.$html;
        }
        echo str_repeat('</li></ul>', $depth + 1);
    }

    public static function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

    public static function price($price) {
        return number_format($price, 0, '.', ' ');
    }

    public static function getNumEnding($number, $endingArray) {
        $number = $number % 100;
        if ($number >= 11 && $number <= 19) {
            $ending = $endingArray[2];
        } else {
            $i = $number % 10;
            switch ($i) {
                case (1): $ending = $endingArray[0]; break;
                case (2): case (3): case (4): $ending = $endingArray[1]; break;
                default: $ending=$endingArray[2];
            }
        }
        return $ending;
    }

    public static function tel($phone) {
        $res = explode('доб', mb_strtolower($phone));

        foreach ($res as $k => $v) {
            $res[$k] = preg_replace('/^[87]/', '+7', preg_replace('/[^0-9]+/', '', $v));
        }
        return implode(',', $res);
    }

    public static function textBR($text, $separator = '<br />')
    {
        return str_replace("\r\n", $separator, $text);
    }

    public static function redactorText($text, $replaces = []) {
        $text = str_replace(array_keys($replaces), array_values($replaces), $text);

        return $text;
    }

    public static function filesize_formatted($path)
    {
        $size = filesize(Yii::getAlias('@webroot') . $path);
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . '&nbsp;' . $units[$power];
    }

    public static function str_date($date) {
        $datetime1 = new DateTime('now');
        $datetime2 = new DateTime($date);
        $interval = $datetime1->diff($datetime2);
        switch((int)$interval->format('%R%a')) {
            case 0:
                return 'Сегодня';
            case -1:
                return 'Вчера';
        }

        return $date;
    }

    public static function yt_video_embed($yt_video)
    {
        if (!empty($yt_video)) {
            return preg_replace(
                "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                "https://www.youtube.com/embed/$2",
                $yt_video
            );
        }

        return $yt_video;
    }

    public static function yt_video_code($yt_video)
    {
        if (!empty($yt_video)) {
            $yt_video = str_replace('https://www.youtube.com/embed/', '', $yt_video);
            $yt_video = str_replace('https://www.youtube.com/watch?v=', '', $yt_video);
            $yt_video = preg_replace('/\?.*/', '', $yt_video);
            $res = preg_replace(
                "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
                "$2",
                $yt_video
            );
            $res = current(explode('&', $res));

            return $res;
        }

        return $yt_video;
    }

    public static function ImgUrl($src) {
        return str_replace(' ', '%20', $src);
    }

    public static function Alt($alt) {
        return str_replace(['[[', ']]'], ['', ''], $alt);
    }
}