<?php

namespace app\helpers\base;

use app\components\base\Menu;
use app\models\Language;
use app\models\SystemMenu;
use app\models\SystemMenuType;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

class MenuHelper {
    public static $menu = false;
    public static $menu_active_idx = false;
    public static $breadcrumbs = false;

    private static function init() {
        if (static::$menu === false) {
            $cacheKey = ['publicmenu', SystemHelper::Language()->id];
            if (Yii::$app->params['admin']['debug'] || (static::$menu = Yii::$app->cache->get($cacheKey)) === false) {
                static::$menu = new Menu(SystemMenu::find()->roots()->one(), true, ArrayHelper::getColumn(SystemMenuType::find()->all(), 'handle'), 'main_menu');

                if (!Yii::$app->params['admin']['debug']) Yii::$app->cache->set($cacheKey, static::$menu, 86400, new TagDependency(['tags' => 'tree']));
            }

            static::$menu_active_idx = static::$menu->setActiveByRequestUrl('main');
            //if ($menuActiveIdx) $breadcrumbs = static::$menu->getBreadcrumbs($menuActiveIdx);
        }
    }

    /**
     * @return Menu
     */
    public static function menu() {
        static::init();

        return static::$menu;
    }

    public static function draw($type = 'main', $template = '@app/views/admin/menu/basemenu', $options = [], $maxDepth = 5, $parentId = false) {
        static::init();

        if (static::$menu !== false) {
            return static::$menu->draw($type, $template, $options, $maxDepth, $parentId);
        }

        return '';
    }

    public static function draw_submenu($type = 'main', $template = '@app/views/admin/menu/basemenu', $options = [], $maxDepth = 5) {
        static::init();

        if (static::$menu_active_idx !== false) {
            $parent_id = false;

            if (!empty(static::$menu->menu[static::$menu_active_idx]['children'][$type])) {
                $parent_id = static::$menu_active_idx;
            } elseif(!empty(static::$menu->menu[static::$menu_active_idx]['parents'][$type])) {
                $parent_id = current(static::$menu->menu[static::$menu_active_idx]['parents'][$type]);
            }

            if (static::$menu !== false && $parent_id !== false) {
                return static::$menu->draw($type, $template, $options, $maxDepth, $parent_id);
            }
        }

        return '';
    }

    public static function breadcrumbs() {
        if (static::$breadcrumbs === false) {
            $menu = static::menu();
            static::$breadcrumbs = [];
            $res = array_merge($menu->getBreadcrumbs(static::$menu_active_idx), Yii::$app->controller->breadcrumbs);

            $last = false;
            foreach ($res as $res_item) {
                if ($last === false || $last['url'] != $res_item['url'] || $last['label'] != $res_item['label']) {
                    static::$breadcrumbs[] = $res_item;
                    $last = $res_item;
                }
            }
        }

        return static::$breadcrumbs;
    }
}