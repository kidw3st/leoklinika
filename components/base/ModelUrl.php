<?php
namespace app\components\base;

use Yii;

class ModelUrl
{
    public $urls = [];

    public function __construct($handle)
    {
        $handles = explode('/', $handle);
        foreach($handles as $k => $handleItem) {
            $handles[$k] = explode('-', $handleItem);
        }

        $lastKey = -1;
        foreach($handles as $handleItem) {
            if ($handleItem[0] == 'mod') $lastKey++;

            $this->urls[$lastKey][$handleItem[0]] = array_slice($handleItem, 1);
        }
    }

    public function createUrl($params) {
        $urls = $this->urls;
        $url = [];

        foreach ($params as $pKey => $pVal) {
            $url[$pKey] = is_array($pVal)?$pVal:[$pVal];
        }

        if (empty($url['mod'])) {
            $lastUrl = end($urls);
            $url['mod'] = $lastUrl['mod'];
        }

        uksort($url, function($a, $b) {
            $sort = array_flip(['mod', 'act', 'id']);

            $aVal = !isset($sort[$a])?1000:$sort[$a];
            $bVal = !isset($sort[$b])?1000:$sort[$b];

            if ($aVal > $bVal) return 1;
            if ($aVal < $bVal) return -1;
            return 0;
        });
        $urls[] = $url;

        return $this->getUrl($urls);
    }

    public function getHandle($urls = false) {
        if ($urls === false) $urls = $this->urls;

        $handles = [];
        foreach ($urls as $url) {
            foreach ($url as $pKey => $pVal) {
                array_unshift($pVal, $pKey);
                $handles[] = implode('-', $pVal);
            }
        }
        $handle = implode('/', $handles);

        return $handle;
    }

    public function getUrl($urls = false, $params = []) {
         return Yii::$app->urlManager->createUrl(array_merge(['admin/model/index', 'handle' => $this->getHandle($urls)], $params));
    }

    public function getModel() {
        $url = end($this->urls);

        return '\\app\\models\\' . $url['mod'][0];
    }

    public function getBack() {
        $urls = $this->urls;

        if (count($urls) > 1) {
            array_pop($urls);

            return new static($this->getHandle($urls));
        }
        return false;
    }

    public function getBreadcrumbs() {
        $breadcrumbs = [];

        $urls = $this;

        $templates = [
            'index' => ['Список [content]', 'Р', true],
            'form' => ['Редактирование [content]', 'Р', false],
            'tree' => ['Дерево [content]', 'Р', false],
        ];

        do {
            $classname = $urls->model;
            $act = $urls->act;

            $breadcrumbs[] = [
                'label' => $classname::getLabelTemplate($templates[$act][0], $templates[$act][1], $templates[$act][2]),
                'url' => $urls->url,
                'icon' => '',
            ];

            $urls = $urls->back;
        } while ($urls);

        return array_reverse($breadcrumbs);
    }

    public function __get($name)
    {
        $url = end($this->urls);

        if (method_exists($this, 'get' . ucfirst($name))) {
            $method = 'get' . ucfirst($name);
            return $this->{$method}();
        }
        $names = explode('_', $name);
        if (array_pop($names) == 'array' && !empty($url[implode('_', $names)]) ) {
            return $url[implode('_', $names)];
        }
        if (!empty($url[$name])) {
            return implode('-', $url[$name]);
        }

        return false;
    }

    public static function getHandleByClass($classname) {
        return [str_replace('app\\models\\', '', $classname)];
    }
}
