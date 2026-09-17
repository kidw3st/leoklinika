<?php

namespace app\components\base;

use app\helpers\base\SystemHelper;
use app\models\SystemStructure;
use Yii;
use yii\base\BootstrapInterface;
use yii\caching\TagDependency;

class Route implements BootstrapInterface
{
    public function bootstrap($app)
    {
        SystemHelper::Language();
        $cacheKey = ['structure'];
        if ($app->params['admin']['debug'] ||
            ($rules = Yii::$app->cache->get($cacheKey)) === false) {
            $rules = [];
            if (Yii::$app->db->schema->getTableSchema('system_structure')) {
                $structures = SystemStructure::find()->ordered()->all();
                foreach ($structures as $structure) {
                    $controller = 'app\\controllers\\' . $structure->controller . 'Controller';

                    if (class_exists($controller) && method_exists($controller, 'getRules')) {
                        $controllerRules = $controller::getRules();
                        $newRules = [];
                        foreach ($controllerRules as $k => $v) {
                            if (is_array($v)) {
                                $newRules[$k] = $v;
                                $pattern = str_replace('[url]', $structure->url, $newRules[$k]['pattern']);
                                $newRules[$k]['pattern'] = ($pattern == $newRules[$k]['pattern']) ? ($structure->url . $newRules[$k]['pattern']) : $pattern;
                            } else {
                                $pattern = str_replace('[url]', $structure->url, $k);
                                $newRules[($pattern == $k) ? ($structure->url . $k) : ($pattern)] = $v;
                            }
                        }

                        $rules = array_merge($rules, $newRules);
                    }
                }

                if (!$app->params['admin']['debug']) Yii::$app->cache->set($cacheKey, $rules, 86400*30, new TagDependency(['tags' => 'admin']));
            }
        }

        if (!empty($rules)) $app->urlManager->addRules($rules);
    }
}