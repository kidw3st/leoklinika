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

class MembersController extends PublicController
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

    public static $uniqId = 'members';
    public static $controllerTitle = 'Сотрудники';

    public function actionIndex($sort = false, $search = false, $page = 1)
    {
        $this->body_class = 'team page';

        $filter = Yii::$app->request->get('filter', []);
        if (empty($filter['type'])) $filter['type'] = 'adult';

        $criteria = Member::find()->published()->distinct();

        if (!empty($search)) $criteria->joinWith('directs')->search_in_fields($search, ['member.title', 'member_direct.title']);
        if (!empty($filter['type'])) $criteria->andWhere(['direct_type_'.$filter['type'] => 1]);
        if (!empty($filter['direction'])) $criteria->joinWith('directs')->andWhere(['member_direct.id' => $filter['direction']]);
        if (!empty($filter['qualify'])) $criteria->andWhere(['qualify_id' => $filter['qualify']]);
        if (!empty($filter['filial'])) $criteria->joinWith('filials')->andWhere(['filial.id' => $filter['filial']]);
        $criteria->orderBy('weight ASC');
        if ($sort == 'abc') $criteria->orderBy('title ASC');
        if ($sort == 'exp') $criteria->orderBy('experience DESC');

        $page_size = SystemSettings::getParam('members', 'page_size', 4);
        $pages = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, Yii::$app->request->queryParams, $page - 1);
        $members = $criteria->limit($pages->limit + $pages->offset)->all();

        $filter_variants = [
            'direction' => [
                'title' => 'Выберите направление',
                'items' => ArrayHelper::index(MemberDirect::find()->published()->all(), 'id'),
            ],
            'qualify' => [
                'title' => 'Категория врача',
                'items' => ArrayHelper::index(MemberQualify::find()->published()->all(), 'id'),
            ],
            'filial' => [
                'title' => 'Выберите клинику',
                'items' => ArrayHelper::index(Filial::find()->published()->all(), 'id'),
            ],
        ];

        $all_members = Member::find()->all();
        $actions = Action::find()->published()->active_by_dates()->ordered()->limit(10)->all();

        $sort_list = [
            'abc' => 'по алфавиту',
            'exp' => 'по стажу',
        ];

        return $this->render('index', [
            'members' => $members,
            'all_members' => $all_members,
            'actions' => $actions,
            'title_seo' => SystemSettings::getParam('members', 'title_seo', '1'),
            'text_seo' => SystemSettings::getParam('members', 'text_seo', '2', false, 3),
            'text_spoiler' => SystemSettings::getParam('members', 'text_spoiler', '3', false, 3),
            'empty_text' => SystemSettings::getParam('members', 'empty_text', '<p>Список пуст</p>', false, 3),
            'sort' => $sort,
            'sort_list' => $sort_list,
            'filter_variants' => $filter_variants,
            'current_filter' => $filter,
            'search' => $search,
            'pages' => $pages,
        ]);
    }

    public function actionDetail($handle)
    {
        $this->body_class = 'team-detail page';

        $member = Member::find()->where(['handle' => $handle])->published()->oneOrNotFound();
        $this->setPageParams($member);

        $actions = Action::find()->published()->active_by_dates()->ordered()->limit(10)->all();
        $show_consult_button = SystemSettings::getParam('members', 'show_consult_button', 1);
        $articles_title = SystemSettings::getParam('members', 'articles_title', 'Статьи доктора');
        $articles = Article::find()->where(['member_id' => $member->id])->published()->orderBy('date DESC')->limit(3)->all();

        return $this->render('detail', [
            'member' => $member,
            'actions' => $actions,
            'show_consult_button' => $show_consult_button,
            'articles_title' => $articles_title,
            'articles' => $articles,
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Members'])->published()->one();
        if (!$structure) return;

        $controller->addArray('members/index', [], date('c'), 'weekly', '0.8');

        /** @var Member[] $items */
        $items = Member::find()->published()->all();
        foreach ($items as $item) {
            $controller->addArrayFull($item->selfUrl, $item->updated_at_obj->format('c'), 'daily', '0.7');
        }
    }
}
