<?php

namespace app\helpers\base;

use app\models\Language;
use app\models\SystemSettings;
use DateTime;
use Yii;

class SystemHelper {
    public static function safeFileName($fileway, $filename, $function = false) {
        $name = explode('.', $filename);
        $srcname = $name;
        $i = 0;
        while (file_exists($fileway . '/' . implode('.', $name)) && $i < 100) {
            $i++;

            if (!empty($function) && is_callable($function)) {
                $name = $function($srcname, $i);
            } else {
                $name = $srcname;
                $name[0] .= '_' . $i;
            }
        }

        return implode('.', $name);
    }

    public static function copyFile($filewayFrom, $directoryTo, $copy = true) {
        $fileWay = explode('/', $filewayFrom);
        $fileName = array_pop($fileWay);
        $fileWay[] = static::safeFileName($directoryTo, $fileName);

        $filewayTo = $directoryTo . '/' . $fileName;

        if ($copy) {
            copy($filewayFrom, $filewayTo);
        } else {
            rename($filewayFrom, $filewayTo);
        }

        return str_replace(Yii::getAlias('@app/web'), '', $filewayTo);
    }

    public static function full_pathinfo($path_file){
        $path_file = strtr($path_file,array('\\'=>'/'));

        $params = explode('?', $path_file);
        $exp = explode('/', $params[0]);
        $file = array_pop($exp);
        $dirname = implode('/', $exp);
        $fileexp = explode('.', $file);
        $extension = array_pop($fileexp);

        return array(
            'dirname' => $dirname,
            'basename' => $file,
            'extension' => $extension,
            'filename' => implode('.', $fileexp)
        );
    }

    public static function getUrl($add = [], $del = []) {
        list($url, $params) = explode('?', $_SERVER['REQUEST_URI']);
        if ($params != '') {
            $params = explode('&', $params);
        } else {
            $params = [];
        }

        $resparams = [];
        foreach($params as $param) {
            $param = explode('=', $param);
            if (!in_array($param[0], $del) && empty($add[$param[0]])) {
                $resparams[] = implode('=', $param);
            }
        }

        foreach($add as $addKey => $addItem) {
            $resparams[] = $addKey . '=' . $addItem;
        }

        if (count($resparams) > 0) {
            return $url . '?' . implode('&', $resparams);
        }
        return $url;
    }

    public static function changeCurrentUrl($addParams = [], $excludeParams = []) {
        $params = Yii::$app->request->queryParams;

        foreach ($addParams as $k => $val) {
            $params[$k] = $val;
        }

        foreach ($excludeParams as $k => $val) {
            unset($params[$val]);
        }

        return Yii::$app->urlManager->createUrl(array_merge([Yii::$app->controller->action->uniqueId], $params));
    }

    public static function getRandomCode($length = 8, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
        $alphabet = str_split($alphabet.$alphabet.$alphabet.$alphabet);
        shuffle($alphabet);
        $alphabet = implode('', $alphabet);

        return substr($alphabet, 0, $length);
    }

    public static function checkFileIsDownloaded($filepath, $check_time = 5) {
        if (!file_exists($filepath) || is_dir($filepath)) return false;

        $firstsize = filesize($filepath);
        sleep($check_time);
        clearstatcache();
        $secondsize = filesize($filepath);

        return $firstsize == $secondsize;
    }

    public static function getViewBlocks($view, $pattern = 'modal-') {
        $res = '';
        if (!empty($view->blocks)) {
            foreach ($view->blocks as $key => $block) {
                if (strpos($key, $pattern) === 0) {
                    $res .= $block;
                }
            }
        }
        return $res;
    }

    public static function getMonth_extreme_dates($date = false) {
        if ($date === false) $date = date('Y-m-d');
        $date = date('Y-m-01 00:00:00', strtotime($date));
        $end_date = new DateTime($date);
        $end_date->modify('last day of 0 month');
        $end_date = $end_date->format('Y-m-d 23:59:59');

        return [$date, $end_date];
    }

    public static function getTime_parts($time) {
        $hours = floor($time / 3600);
        $minutes = floor(($time - $hours * 3600) / 60);
        $seconds = floor(($time - $hours * 3600 - $minutes * 60) / 1);

        return [substr('0'.$hours, -2), substr('0'.$minutes, -2), substr('0'.$seconds, -2)];
    }

    public static $current_language_handle = false;
    private static $_languages = false;
    private static $_current_language = false;
    private static $_other_language = false;

    /**
     * @return Language
     */
    public static function Language() {
        if (static::$_current_language === false) {
            $admin_page = false;
            if (!Yii::$app->request->isConsoleRequest) {
                UserHelper::init();
                if (strpos(Yii::$app->request->url, '/admin') !== false) $admin_page = true;
            }

            if (empty(static::$current_language_handle) && !Yii::$app->request->isConsoleRequest) {
                $lang = Yii::$app->request->post('lang', Yii::$app->request->get('lang', false));
                if ($lang) static::$current_language_handle = $lang;
            }

            if (!empty(static::$current_language_handle)) {
                static::$_current_language = Language::find()->where(['handle' => static::$current_language_handle])->published()->one();
            } elseif(!empty(Yii::$app->user) && !Yii::$app->user->isGuest && UserHelper::getParam('lang_id') && $admin_page && !Yii::$app->request->isConsoleRequest) {
                static::$_current_language = Language::find()->where(['id' => UserHelper::getParam('lang_id')])->published()->one();
            } elseif(!$admin_page && !Yii::$app->request->isConsoleRequest) {
                $pathInfos = explode('/', Yii::$app->request->pathInfo);
                $languages = static::AllLanguages();

                if ($languages) {
                    foreach ($languages as $language) {
                        if ($pathInfos[0] == $language->handle && $language->is_main != 1) {
                            static::$_current_language = $language;

                            unset($pathInfos[0]);
                            Yii::$app->request->pathInfo = implode('/', $pathInfos);
                            Yii::$app->request->url = preg_replace('/^\/'.$language->handle_real.'/', '', Yii::$app->request->url);
                            if (Yii::$app->request->url == '') Yii::$app->request->url = '/';
                            $_SERVER['REQUEST_URI'] = Yii::$app->request->url;

                            break;
                        }
                    }
                }
            }

            if (empty(static::$_current_language)) {
                static::$_current_language = Language::find()->where(['is_main' => 1])->published()->one();
            }

            if (static::$_current_language && !empty(Yii::$app->request->url) && strpos(Yii::$app->request->url, '/admin') === false)
                Yii::$app->language = static::$_current_language->i18n_code;
        }

        return static::$_current_language;
    }

    /**
     * @return Language
     */
    public static function other_language() {
        if (static::$_other_language === false) {
            static::$_other_language = Language::find()->orderBy(new Expression('id<>'.static::Language()->id. ' DESC'))->one();
        }

        return static::$_other_language;
    }

    public static function setLanguage($language = false) {
        //if (static::$_current_language === false) {
            if ($language === false) $language = Language::find()->where(['is_main' => 1])->published()->one();
            if ($language) {
                static::$_current_language = $language;
                Yii::$app->language = static::$_current_language->i18n_code;
            }
        //}
    }

    /**
     * @return Language[]
     */
    public static function AllLanguages() {
        if (static::$_languages === false) {
            static::$_languages = Language::find()->ordered()->published()->all();
        }

        return static::$_languages;
    }

    public static function LanguageLink($link) {
        if (!preg_match('/^http/', $link) && $link != '') {
            $language = SystemHelper::Language();
            if ($link == '/') return '/' . $language->handle_real;
            return (empty($language->handle_real) ? '' : '/') . $language->handle_real . $link;
        }
        return $link;
    }

    private static $city = false;

    /*public static function City() {
        if (static::$city === false) {
            $geo_id = Yii::$app->request->get('geo_id', Yii::$app->request->post('geo_id', false));
            if ($geo_id) static::$city = City::find()->where(['id' => $geo_id])->one();

            if (empty(static::$city)) {
                $ip = $_SERVER['REMOTE_ADDR'];

                $ip = '95.188.80.221'; //красноярск
                //$ip = '95.220.18.20'; // москва
                //$ip = '176.64.30.239'; // алматы
                //$ip = '176.60.46.123'; // Барановичи

                $geo = GeoLocation::getInfoByIP($ip);
                if ($geo) {
                    static::$city = City::getOrSetCity([
                        [
                            'title' => $geo->info_obj['country'],
                            'type' => 'country',
                        ],
                        [
                            'title' => $geo->info_obj['region'],
                            'type' => 'region',
                        ],
                        [
                            'title' => $geo->info_obj['city'],
                            'type' => 'city',
                        ],
                    ], false);
                }
            }
            if (empty(static::$city)) static::$city = City::find()->where(['is_default' => 1])->one();
        }

        return static::$city;
    }*/

    public static function hidden_inputs($variables, $base_var = '') {
        $res = '';
        foreach ($variables as $k => $variable) {
            $base = $base_var . '['.$k.']';
            if (empty($base_var)) $base = $k;
            if (is_array($variable)) {
                $res .= static::hidden_inputs($variable, $base);
            } else {
                $res .= '<input type="hidden" name="' . $base . '" value="' . $variable . '">';
            }
        }

        return $res;
    }

    public static function AbsoluteLink($link, $server_path = false) {
        if (!empty($link)) {
            if ($server_path) return Yii::getAlias('@app/web/') . $link;
            return SystemSettings::getParam('adminbase', 'site_url') . $link;
        }

        return '';
    }

    public static function generate_pdf($filename, $html_content, $stylesheet = false) {
        /*$pdf = new Mpdf();

        if (!empty($stylesheet)) $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html_content, 2);
        $pdf->title = $filename;
        $pdf->showImageErrors = true;

        Yii::$app->response->format = Response::FORMAT_RAW;
        header('Content-Type: application/pdf');
        //header('Content-Length: ' . strlen($content));
        header('Content-Disposition: inline; filename="'.$filename.'.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        return $pdf->Output('', 'S');*/
    }
}