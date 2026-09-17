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
use app\models\Vacancy;
use app\models\VacancyDirect;
use Yii;
use yii\helpers\ArrayHelper;

class VacancyController extends PublicController
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

    public static $uniqId = 'vacancy';
    public static $controllerTitle = 'Вакансии';

    public function actionIndex($page = 1, $direct = false)
    {
        $this->body_class = 'vacancies page';

        $current_direct = false;
        $criteria = Vacancy::find()->published()->ordered();
        if (!empty($direct)) {
            $criteria->andWhere(['direct_id' => $direct]);
            $current_direct = VacancyDirect::find()->where(['id' => $direct])->one();
        }

        $params = [];
        if (!empty($direct)) $params['direct'] = $direct;
        $page_size = SystemSettings::getParam('vacancy', 'page_size', 1);
        $pages = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params, $page - 1);

        $items = $criteria->limit($pages->limit + $pages->offset)->all();

        $direct_ids = ArrayHelper::getColumn(Vacancy::find()->select('direct_id')->published()->groupBy('direct_id')->asArray()->all(), 'direct_id');
        $directs = VacancyDirect::find()->ordered()->andWhere(['id' => $direct_ids])->all();

        $items_all = Vacancy::find()->published()->ordered()->all();

        return $this->render('index', [
            'items' => $items,
            'text' => SystemSettings::getParam('vacancy', 'text', '', false, 3),
            'image' => SystemSettings::getParam('vacancy', 'image', '', false, 4),
            'pages' => $pages,
            'directs' => $directs,
            'current_direct' => $current_direct,
            'items_all' => $items_all,
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Vacancy'])->published()->one();
        if (!$structure) return;

        $controller->addArray('vacancy/index', [], date('c'), 'weekly', '0.8');
    }
}
