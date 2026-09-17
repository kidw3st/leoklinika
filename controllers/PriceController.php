<?php

namespace app\controllers;

use app\components\base\Pagination;
use app\controllers\base\PublicController;
use app\models\Action;
use app\models\Article;
use app\models\Filial;
use app\models\Member;
use app\models\MemberDirect;
use app\models\MemberQualify;
use app\models\Service;
use app\models\SystemSettings;
use app\models\SystemStructure;
use Yii;
use yii\helpers\ArrayHelper;

class PriceController extends PublicController
{
    public $doPageController = true;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/',
                'route' => static::$uniqId.'/index',
            ],
        ];
    }

    public static $uniqId = 'price';
    public static $controllerTitle = 'Прайслист';

    public function actionIndex($search = false, $tag = false)
    {
        $this->body_class = 'price page';

        $filter = Yii::$app->request->get('filter', []);

        $criteria = Service::find_base()->distinct()->rightJoin('service_price AS sp', 'sp.service_id=service.id');

        if (!empty($search)) {
            $criteria->joinWith('prices');
            $criteria->search_in_fields($search, ['service.title', 'service_price.title']);
        }
        if (!empty($filter['direction'])) {
            $service = Service::find_base()->where(['id' => $filter['direction']])->one();
            $criteria->andWhere(['>=', 'lft', $service->lft])->andWhere(['<=', 'rgt', $service->rgt]);
        }
        if (!empty($filter['filial'])) $criteria->joinWith('filials')->andWhere(['filial.id' => $filter['filial']]);

        $services = $criteria->all();
        $service_ids = ArrayHelper::getColumn($services, 'id');

        $root_services = false;
        if ($services) {
            $root_services = Service::findBySql('SELECT DISTINCT s1.* FROM service AS s1, service AS s2 WHERE s2.id IN (' . implode(', ', $service_ids) . ') AND s1.depth=1 AND s1.lft <= s2.lft AND s1.rgt >= s2.rgt')->all();
        }

        if ($tag) {
            $services = Service::findBySql('SELECT DISTINCT s2.* FROM service AS s1, service AS s2 WHERE s2.id IN (' . implode(', ', $service_ids) . ') AND s1.id IN (' . $tag . ') AND s1.lft <= s2.lft AND s1.rgt >= s2.rgt')->all();
            $service_ids = ArrayHelper::getColumn($services, 'id');
        }

        $filter_variants = [
            'direction' => [
                'title' => 'Выберите направление',
                'items' => ArrayHelper::index(Service::find_base()->where(['depth' => 1])->all(), 'id'),
            ],
            'filial' => [
                'title' => 'Выберите клинику',
                'items' => ArrayHelper::index(Filial::find()->all(), 'id'),
            ],
        ];

        $service = Service::find_base()->orderBy('lft ASC')->one();
        $pricelist = $service->getPricelist(false, $service_ids, $search);

        $actions = Action::find()->published()->active_by_dates()->ordered()->limit(10)->all();
        $popular_services = Service::find_base()->published()->andWhere(['is_popular' => 1])->all();

        return $this->render('index', [
            'pricelist' => $pricelist,
            'popular_services' => $popular_services,
            'root_services' => $root_services,
            'actions' => $actions,
            'tag' => $tag,
            'title_seo' => SystemSettings::getParam('price', 'title_seo', '1'),
            'text_seo' => SystemSettings::getParam('price', 'text_seo', '2', false, 3),
            'text_spoiler' => SystemSettings::getParam('price', 'text_spoiler', '3', false, 3),
            'filter_variants' => $filter_variants,
            'current_filter' => $filter,
            'search' => $search,
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Price'])->published()->one();
        if (!$structure) return;

        $controller->addArray('price/index', [], date('c'), 'weekly', '0.8');
    }
}
