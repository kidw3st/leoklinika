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
use app\models\News;
use app\models\RequestReview;
use app\models\Service;
use app\models\SystemSettings;
use app\models\SystemStructure;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class BlogController extends PublicController
{
    public $doPageController = true;

    public static function getRules($type = false)
    {
        return [
            [
                'pattern' => '/<type:(news|articles)>/<handle:[-\_\/\w]+>',
                'route' => static::$uniqId.'/detail',
                'encodeParams' => false,
            ],
            [
                'pattern' => '/',
                'route' => static::$uniqId.'/index',
            ],
        ];
    }

    public static $uniqId = 'blog';
    public static $controllerTitle = 'Блог';

    public function actionIndex($type = 'news', $page = 1, $more = false, $from = false, $member = false)
    {
        $classname = News::class;
        if ($type == 'articles') $classname = Article::class;
        $this->body_class = 'blog__page page';

        $criteria = $classname::find()->published()->orderBy('date DESC');

        if (!empty($member) && $type == 'articles') $criteria->andWhere(['member_id' => $member]);

        $page_size = SystemSettings::getParam('blog', 'page_size', 4);
        $params = [];
        if (!empty($type)) $params['type'] = $type;
        if (!empty($member)) $params['member'] = $member;
        if ($more && $from) $params['from'] = $from;
        if (!$more) $params['from'] = $page;
        $pages = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params + ['from' => $page], $page - 1);
        $pages_more = Pagination::getPages($criteria->count(), $page_size, Yii::$app->controller->action->uniqueId, $params + ['more' => 1], $page - 1);
        if ($more) {
            $items = $criteria->offset($page_size * (($from?$from:1) - 1))->limit($pages->limit + $pages->offset - $page_size * (($from?$from:1) - 1))->all();
        } else {
            $items = $criteria->limit($pages->limit)->offset($pages->offset)->all();
        }

        $members = false;
        if ($type == 'articles') {
            $ids = ArrayHelper::getColumn(Article::find()->select('member_id')->published()->groupBy('member_id')->asArray()->all(), 'member_id');
            if (!empty($ids)) $members = Member::find()->where(['id' => $ids])->all();
        }
        if (!empty($member)) $member = Member::find()->where(['id' => $member])->one();

        return $this->render('index', [
            'items' => $items,
            'type' => $type,
            'types' => [
                'news' => 'Новости',
                'articles' => 'Статьи',
            ],
            'current_member' => $member,
            'members' => $members,
            'pages' => $pages,
            'pages_more' => $pages_more,
        ]);
    }

    public function actionDetail($handle, $type)
    {
        $this->body_class = 'blog-detail page';

        $classname = News::class;
        if ($type == 'articles') $classname = Article::class;

        /** @var \app\models\News|\app\models\Article $item */
        $item = $classname::find()->where(['handle' => $handle])->published()->oneOrNotFound();
        $this->setPageParams($item);

        $all_items = $classname::find()->published()->orderBy('date DESC')->all();
        $prev = false;
        $next = false;
        $found = false;
        foreach ($all_items as $all_item) {
            if ($found) {
                $next = $all_item;
                break;
            }
            if ($all_item->id == $item->id) {
                $found = true;
            }
            if (!$found) $prev = $all_item;
        }

        $other_items = $classname::find()->where(['<>', 'id', $item->id])->published()->orderBy('date DESC')->limit(10)->all();

        return $this->render('detail', [
            'item' => $item,
            'prev' => $prev,
            'next' => $next,
            'other_items' => $other_items,
        ]);
    }

    public static function sitemap($controller) {
        $structure = SystemStructure::find()->where(['controller' => 'Blog'])->published()->one();
        if (!$structure) return;

        $controller->addArray('blog/index', [], date('c'), 'weekly', '0.8');

        /** @var News[] $items */
        $items = News::find()->published()->all();
        foreach ($items as $item) {
            $controller->addArrayFull($item->selfUrl, $item->updated_at_obj->format('c'), 'daily', '0.7');
        }

        /** @var Article[] $items */
        $items = Article::find()->published()->all();
        foreach ($items as $item) {
            $controller->addArrayFull($item->selfUrl, $item->updated_at_obj->format('c'), 'daily', '0.7');
        }
    }
}
