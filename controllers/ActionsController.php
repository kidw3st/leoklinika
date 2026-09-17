<?php

namespace app\controllers;

use app\components\base\Pagination;
use app\controllers\base\PublicController;
use app\models\Action;
use app\models\ActionAdvantage;
use app\models\ActionTag;
use app\models\Article;
use app\models\Filial;
use app\models\Member;
use app\models\MemberDirect;
use app\models\MemberQualify;
use app\models\RequestReview;
use app\models\Service;
use app\models\SystemSettings;
use app\models\SystemStructure;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class ActionsController extends PublicController
{
    public $doPageController = true;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/<handle:[-\_\/\w]+>',
                'route' => static::$uniqId.'/detail',
                'encodeParams' => false,
            ],
            [
                'pattern' => '/',
                'route' => static::$uniqId.'/index',
            ],
        ];
    }

    public static $uniqId = 'actions';
    public static $controllerTitle = 'Акции';

    public function actionIndex($tag = false, $page = 1, $more = false, $from = false)
    {
        $this->body_class = 'promos-general page';

        $criteria = Action::find()->distinct()->active_by_dates()->joinWith('tags', false);

        if (!empty($tag)) $criteria->andWhere(['action_tag.id' => $tag]);

        $page_size = SystemSettings::getParam('actions', 'page_size', 4);
        $params = [];
        if (!empty($tag)) $params['tag'] = $tag;
        if ($more && $from) $params['from'] = $from;
        if (!$more) $params['from'] = $page;
        $pages = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params + ['from' => $page], $page - 1);
        $pages_more = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params + ['more' => 1], $page - 1);
        if ($more) {
            $actions = $criteria->offset($page_size * (($from?$from:1) - 1))->limit($pages->limit + $pages->offset - $page_size * (($from?$from:1) - 1))->all();
        } else {
            $actions = $criteria->limit($pages->limit)->offset($pages->offset)->all();
        }
        $tag_ids = ArrayHelper::getColumn(Action::find()->select('action_tag.id')->active_by_dates()->joinWith('tags', false)->groupBy('action_tag.id')->asArray()->all(), 'id');
        $tags = false;
        if (!empty($tag_ids)) $tags = ActionTag::find()->where(['id' => $tag_ids])->ordered()->published()->all();
        $reviews = RequestReview::find()->published()->orderBy('date DESC')->limit(5)->all();

        return $this->render('index', [
            'actions' => $actions,
            'intro' => SystemSettings::getParam('actions', 'intro', '<p>Вступление</p>', false, 3),
            'current_tag' => $tag,
            'tags' => $tags,
            'pages' => $pages,
            'pages_more' => $pages_more,
            'reviews' => $reviews,
        ]);
    }

    public function actionDetail($handle)
    {
        $this->body_class = 'promos-detail page';

        /** @var Action $action */
        $action = Action::find()->where(['handle' => $handle])->active_by_dates()->published()->oneOrNotFound();
        $this->setPageParams($action);

        $criteria = Action::find()->published()->active_by_dates()->limit(10)->ordered();
        if (!empty($action->service)) $criteria->orderBy(new Expression('(service_id='.$action->service_id.') DESC, weight ASC'));
        $actions = $criteria->all();
        $advantages = ActionAdvantage::find()->ordered()->published()->all();
        $member_ids = [];
        if ($action->service) $member_ids = $action->service->members_input;
        $filial = Filial::getCurrent();
        $phone = false;
        if (!empty($filial) && !empty($filial->phones_arr[0])) $phone = $filial->phones_arr[0];

        return $this->render('detail', [
            'action' => $action,
            'actions' => $actions,
            'advantages' => $advantages,
            'member_ids' => $member_ids,
            'phone' => $phone,
            'title_images' => SystemSettings::getParam('action', 'title_images', 'Какое оборудование мы используем в диагностике и работе'),
            'title_advantages' => SystemSettings::getParam('action', 'title_advantages', 'Почему выбирают нашу клинику'),
            'title_members' => SystemSettings::getParam('action', 'title_members', 'Ведущие врачи'),
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Actions'])->published()->one();
        if (!$structure) return;

        $controller->addArray('actions/index', [], date('c'), 'weekly', '0.8');

        /** @var Action[] $items */
        $items = Action::find()->published()->active_by_dates()->all();
        foreach ($items as $item) {
            $controller->addArrayFull($item->selfUrl, $item->updated_at_obj->format('c'), 'daily', '0.7');
        }
    }
}
