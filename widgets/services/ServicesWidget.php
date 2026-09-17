<?php

namespace app\widgets\services;

use app\components\base\CActiveQuery;
use app\components\base\Pagination;
use app\models\Filial;
use app\models\Service;
use app\models\ServiceTag;
use app\models\SystemSettings;
use Yii;
use yii\helpers\ArrayHelper;

class ServicesWidget extends \yii\base\Widget {
    public $title;
    public $only_popular = false;
    public $options = [];
    public $page_size = 16;
    public $page_more = false;
    public $template = 'index';
    public $ids = false;
    public $link_enable = true;
    public $use_filter_filials = false;
    public $use_filter_directions = false;
    public $default_type = false;
    public $title_class = '';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $page = Yii::$app->request->get('page_'.$this->id, 1);
        $current_tag = Yii::$app->request->get('tag', false);
        $current_type = Yii::$app->request->get('type', $this->default_type);
        $current_filter = Yii::$app->request->get('filter', []);
        $search = Yii::$app->request->get('search', false);
        $search_title = 'Результат поиска';
        if ($this->only_popular) $search_title = 'Популярные услуги';
        $current_filter_objects = [];

        /** @var CActiveQuery $criteria */
        $criteria = Service::find_base()->distinct()->published()->andWhere(['>', 'depth', 0])->orderBy('lft ASC')->joinWith('tags', false);
        if ($this->only_popular) $criteria->andWhere(['is_popular' => 1]);
        if ($current_type) $criteria->andWhere(['type' => $current_type]);
        $criteria_tags = clone $criteria;
        if ($search) {
            $criteria->joinWith('prices');
            $criteria->search_in_fields($search, ['service.title', 'text', 'service_price.title']);
        }
        if ($this->ids) $criteria->andWhere(['service.id' => $this->ids]);

        if ($current_tag) $criteria->andWhere(['service_tag.id' => $current_tag]);

        $filter = [];
        if ($this->use_filter_directions) {
            $filter['directions'] = Service::find_base()->published()->orderBy('lft ASC')->andWhere(['depth' => 1])->all();
            if (!empty($current_filter['direction'])) {
                $current_filter_objects['direction'] = Service::find()->published()->andWhere(['id' => $current_filter['direction']])->one();
            }
        }

        if ($this->use_filter_filials) {
            $filter['filials'] = Filial::find()->published()->ordered()->all();
            if (!empty($current_filter['filial'])) {
                $current_filter_objects['filial'] = Filial::find()->published()->andWhere(['id' => $current_filter['filial']])->one();
            }
        }

        if (!empty($current_filter_objects['direction'])) $criteria->andWhere(['>=', 'lft', $current_filter_objects['direction']->lft])->andWhere(['<=', 'rgt', $current_filter_objects['direction']->rgt]);
        if (!empty($current_filter_objects['filial'])) $criteria->joinWith('filials')->andWhere(['filial.id' => $current_filter_objects['filial']->id]);

        $tags = [];
        $service_ids = ArrayHelper::getColumn($criteria_tags->all(), 'id');
        if (!empty($service_ids)) {
            $tag_ids = Yii::$app->db->createCommand('SELECT tag_id FROM service2tag WHERE service_id IN (' . implode(', ', $service_ids) . ') GROUP BY tag_id')->queryAll();
            $tag_ids = ArrayHelper::getColumn($tag_ids, 'tag_id');
            $tags = ServiceTag::find()->where(['id' => $tag_ids])->ordered()->published()->all();
        }

        if ($criteria->count() == 0 && $this->template == 'search') {
            $criteria = Service::find_base()->distinct()->published()->andWhere(['>', 'depth', 0])->orderBy('lft ASC')->joinWith('tags', false);
            $criteria->andWhere(['is_popular' => 1]);
            $search_title = SystemSettings::getParam('service', 'empty_text', 'По вашему запросу ничего не найдено, посмотрите наиболее популярные услуги ниже');
        }

        $pages = Pagination::getPages($criteria->count(), $this->page_size, Yii::$app->controller->action->uniqueId, Yii::$app->request->queryParams, $page - 1, 'page_'.$this->id, true);
        if ($this->page_more) {
            $services = $criteria->limit($pages->limit + $pages->offset)->all();
        } else {
            $services = $criteria->limit($pages->limit)->offset($pages->offset)->all();
        }

        return $this->render($this->template, [
            'title' => $this->title,
            'link_all' => Service::indexUrl(),
            'tags' => $tags,
            'services' => $services,
            'current_tag' => $current_tag,
            'current_type' => $current_type,
            'pjax_id' => 'services_' . $this->id,
            'pages' => $pages,
            'link_enable' => $this->link_enable,
            'options' => $this->options,
            'filter' => $filter,
            'current_filter' => $current_filter,
            'current_filter_objects' => $current_filter_objects,
            'search' => $search,
            'search_title' => $search_title
        ]);
    }
}