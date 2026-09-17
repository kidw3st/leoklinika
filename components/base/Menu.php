<?php

namespace app\components\base;

use app\helpers\base\SystemHelper;
use app\models\Service;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class Menu {
    public $id = 'menu';
    public $menu = false;
    public $menuTypes = ['main'];
    private static $menuTemplates = [];
    public $active_ids = [];

    /**
     * Menu constructor.
     * @param CActiveRecordTree $model
     */
    function __construct($model = false, $public = false, $types = false, $id = false) {
        if ($types !== false) $this->menuTypes = $types;
        if ($id !== false) $this->id = $id;

        $this->readModelTree($model, '', false, false, $public);
    }

    /**
     * @param CActiveRecordTree $model
     * @param string $suffix
     */
    public function readModelTree($model, $suffix = '', $parentKey = false, $types = false, $public = false) {
        foreach ($model->children(1)->all() as $child) {
            if ($public === false || $child->public >= 1) {
                $modelKey = $parentKey ?: ($suffix . $model->id);
                $childKey = $suffix . $child->id;
                $curTypes = $types;
                if (!$curTypes && isset($child->types)) $curTypes = ArrayHelper::getColumn($child->types, 'handle');
                if (!$curTypes) $curTypes = ['main'];
                $menuRow = [
                    'label' => $child->title,
                    'label_2' => $child->title_2,
                    'label_3' => $child->title_3,
                    'url' => $child->generate_url,
                    'basic_url' => $child->basic_url,
                    'active' => false,
                    'model' => $child,
                    'types' => $curTypes,
                ];

                if (empty($menuRow['label_2'])) $menuRow['label_2'] = $menuRow['label'];
                if (empty($menuRow['label_3'])) $menuRow['label_3'] = 'Смотреть всё';

                foreach ($this->menuTypes as $type) {
                    $menuRow['children'][$type] = [];
                    $menuRow['parents'][$type] = [];
                }
                $menuRow['children']['main'] = [];
                $menuRow['parents']['main'] = [];
                $this->menu[$childKey] = $menuRow;

                foreach ($curTypes as $type) {
                    if (!empty($this->menu[$modelKey]) && in_array($type, $this->menu[$modelKey]['types'])) {
                        $this->menu[$childKey]['parents'][$type] = array_merge([$modelKey], $this->menu[$modelKey]['parents'][$type]);
                        $this->menu[$modelKey]['children'][$type][] = $childKey;
                    }
                }

                $this->readModelTree($child, $suffix, false, $types, $public);

                if (!empty($child->is_service)) {
                    $root_service = Service::find()->orderBy('lft ASC')->one();
                    $this->addService($root_service, 'service_' . $child->id . '_', $childKey, $curTypes, $public);
                }
            }
        }
    }

    public function addService($model, $suffix = '', $parentKey = false, $types = false, $public = false) {
        foreach ($model->children(1)->all() as $child) {
            if ($public === false || $child->public >= 1) {
                $modelKey = $parentKey ?: ($suffix . $model->id);
                $childKey = $suffix . $child->id;
                $curTypes = $types;
                $menuRow = [
                    'label' => $child->title,
                    'url' => $child->selfUrl,
                    'basic_url' => $child->selfUrl,
                    'active' => false,
                    //'model' => $child,
                    'types' => $curTypes,
                ];

                if (empty($menuRow['label_2'])) $menuRow['label_2'] = $menuRow['label'];
                if (empty($menuRow['label_3'])) $menuRow['label_3'] = 'Смотреть всё';

                foreach ($this->menuTypes as $type) {
                    $menuRow['children'][$type] = [];
                    $menuRow['parents'][$type] = [];
                }
                $menuRow['children']['main'] = [];
                $menuRow['parents']['main'] = [];
                $this->menu[$childKey] = $menuRow;

                foreach ($curTypes as $type) {
                    if (!empty($this->menu[$modelKey]) && in_array($type, $this->menu[$modelKey]['types'])) {
                        $this->menu[$childKey]['parents'][$type] = array_merge([$modelKey], $this->menu[$modelKey]['parents'][$type]);
                        $this->menu[$modelKey]['children'][$type][] = $childKey;
                    }
                }

                $this->addService($child, $suffix, false, $types, $public);
            }
        }
    }

    public function setActiveByRequestUrl($menuType = false, $only_get = false) {
        $searhUrls = [];

        $url = current(explode('?', Yii::$app->request->url));
        $urls = explode('/', $url);
        while(count($urls) > 0) {
            $searhUrls[] = implode('/', $urls);
            array_pop($urls);
        }

        $res = false;
        $res_depth = false;

        foreach ($searhUrls as $url) {
            if (!empty($this->menu)) {
                foreach ($this->menu as $k => $menu) {
                    $menuUrl = current(explode('?', $menu['basic_url']));

                    if ($url == $menuUrl && ($menuType === false || in_array($menuType, $menu['types']))) {
                        if (!$only_get) $this->setActive($k);

                        if ($res_depth === false || $res_depth < $menu['model']->depth) {
                            $res_depth = $menu['model']->depth;
                            $res = $k;
                        }
                    }
                }
            }
        }

        return $res;
    }

    public function setActive($index) {
        if (!empty($this->menu[$index])) {
            $this->menu[$index]['active'] = true;
            $this->active_ids[] = $index;
            foreach ($this->menu[$index]['parents'] as $type => $parents) {
                foreach ($parents as $k => $menuIndex) {
                    $this->menu[$menuIndex]['active'] = true;
                    $this->active_ids[] = $menuIndex;
                }
            }
        }
    }

    public function getArray($type = 'main', $parentId = false) {
        $result = [];
        $ids = [];
        if ($parentId) {
            if (count($this->menu[$parentId]['children'][$type]) > 0) {
                $ids = $this->menu[$parentId]['children'][$type];
            }
        } else {
            if (!empty($this->menu)) {
                foreach ($this->menu as $k => $menuItem) {
                    if (isset($menuItem['parents'][$type]) && count($menuItem['parents'][$type]) == 0 && in_array($type, $menuItem['types'])) $ids[] = $k;
                }
            }
        }
        $result = $this->getArrayRecursive($type, $ids);

        return $result;
    }

    private function getArrayRecursive($type = 'main', $ids) {
        $result = [];
        foreach($ids as $id) {
            $result_item = [
                'name' => $this->menu[$id]['label'],
                'url' => $this->menu[$id]['url'],
            ];

            if (count($this->menu[$id]['children'][$type]) > 0) {
                $result_item['children'] = $this->getArrayRecursive($type, $this->menu[$id]['children'][$type]);
            }

            $result[] = $result_item;
        }
        return $result;
    }

    public function draw($type = 'main', $template = '@app/views/admin/menu/basemenu', $options = [], $maxDepth = 5, $parentId = false) {
        $cacheKey = ['publicmenu_draw', SystemHelper::Language()->id, $this->id, $type, $template, $options, $maxDepth, $parentId];
        if (Yii::$app->params['admin']['debug'] || ($menu_str = Yii::$app->cache->get($cacheKey)) === false) {
            $controller = Yii::$app->controller;

            $defaultOptions = [
                'template' => $template,
            ];

            $resOptions = ArrayHelper::merge($defaultOptions, $options);

            $templates = [];
            if (isset(static::$menuTemplates[$resOptions['template']])) {
                $templates = static::$menuTemplates[$resOptions['template']];
            } else {
                $lastFound = [
                    'container' => $defaultOptions['template'] . '/container1',
                    'row' => $defaultOptions['template'] . '/row1',
                ];
                for ($i = 1; $i <= $maxDepth; $i++) {
                    if (file_exists(Yii::getAlias($resOptions['template'] . '/container' . $i . '.php')))
                        $lastFound['container'] = $resOptions['template'] . '/container' . $i;

                    if (file_exists(Yii::getAlias($resOptions['template'] . '/row' . $i . '.php')))
                        $lastFound['row'] = $resOptions['template'] . '/row' . $i;

                    $templates[$i]['container'] = $lastFound['container'];
                    $templates[$i]['row'] = $lastFound['row'];
                }

                static::$menuTemplates[$resOptions['template']] = $templates;
            }

            $ids = [];
            if ($parentId) {
                if (count($this->menu[$parentId]['children'][$type]) > 0) {
                    $ids = $this->menu[$parentId]['children'][$type];
                }
            } else {
                foreach ($this->menu as $k => $menuItem) {
                    if (count($menuItem['parents'][$type]) == 0 && in_array($type, $menuItem['types'])) $ids[] = $k;
                }
            }

            $menu_str = $this->drawRecursive($controller, $type, $parentId, $ids, $templates, $resOptions, 1, $maxDepth);
            if (!Yii::$app->params['admin']['debug']) Yii::$app->cache->set($cacheKey, $menu_str, 86400, new TagDependency(['tags' => 'tree']));
        }

        $template = function ($menu_id = false) {
            if ($menu_id === false) $menu_id = '[-A-Za-z0-9\_]+';
            return '/\[menu\_('.$menu_id.')\:(.+?)(?:\:(.+?))?\]/';
        };

        foreach ($this->active_ids as $menu_id) {
            $menu_str = preg_replace($template($menu_id), '$2', $menu_str);
        }
        $menu_str = preg_replace($template(), '$3', $menu_str);

        return $menu_str;
    }

    private function drawRecursive($controller, $type, $parentId, $ids, $templates, $options, $lvl = 1, $maxDepth = 5) {
        $containerContent = '';

        if ($lvl > $maxDepth) return '';

        $k = 0;
        foreach($ids as $id) {
            $rowContent = '';
            if (count($this->menu[$id]['children'][$type]) > 0) {
                $rowContent = $this->drawRecursive($controller, $type, $id, $this->menu[$id]['children'][$type], $templates, $options, $lvl + 1, $maxDepth);
            }

            $containerContent .= $controller->renderPartial($templates[$lvl]['row'], ['parent_menu' => !empty($this->menu[$parentId])?$this->menu[$parentId]:false, 'menu' => $this->menu[$id], 'content' => $rowContent, 'lvl' => $lvl, 'options' => $options, 'type' => $type, 'idx' => $id, 'count' => count($ids), 'k' => $k++]);
        }

        if (empty($containerContent)) return '';
        return $controller->renderPartial($templates[$lvl]['container'], ['menu' => !empty($this->menu[$parentId])?$this->menu[$parentId]:false, 'content' => $containerContent, 'lvl' => $lvl, 'options' => $options, 'type' => $type, 'count' => count($ids)]);
    }

    public function getBreadcrumbs($index, $type = 'main') {
        $res = [];

        $res[] = [
            'label' => $this->menu[$index]['label'],
            'url' => $this->menu[$index]['url'],
        ];
        if (!empty($this->menu[$index]['parents'][$type])) {
            foreach ($this->menu[$index]['parents'][$type] as $k => $menuIndex) {
                $res[] = [
                    'label' => $this->menu[$menuIndex]['label'],
                    'url' => $this->menu[$menuIndex]['url'],
                ];
            }
        }

        return array_reverse($res);
    }

    public function getParentActiveIdx($type = 'main') {
        $idx = $this->setActiveByRequestUrl($type, true);

        if (!empty($this->menu[$idx]['parents'][$type])) {
            return end($this->menu[$idx]['parents'][$type]);
        } else {
            return false;
        }
    }
}