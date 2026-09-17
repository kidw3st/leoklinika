<?php
namespace app\models;

use Yii;
use app\models\parents\PageBlockParent;
use yii\caching\TagDependency;

/**
 * This is the model class for table "page_block".
 *
 * @property Action[] $actions_real
 * @property Member[] $members_real
 * @property MemberDirect[] $memberDirects_real
 * @property News[] $news_real
 * @property Article[] $articles_real
 * @property RequestReview[] $reviews_real
 * @property Filial[] $filials_real
 */
class PageBlock extends PageBlockParent
{
    public function attributeLabels()
    {
        $labels = [];

        if ($this->block_type == 'action') $labels['link_title'] = 'Текст кнопки';

        return array_merge(parent::attributeLabels(), $labels, [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
        
        ]);
    }

    /**
     * @param PageBlock $model
     * @return array
     */
    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        if ($model) {
            if ($model->block_type == 'text') $res['fields']['text']['edited'] = true;

            if ($model->block_type == 'text_2') $res['fields']['text']['edited'] = true;

            if ($model->block_type == 'services') $res['fields']['only_popular']['edited'] = true;
            if ($model->block_type == 'services') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'members') $res['fields']['only_lead']['edited'] = true;
            if ($model->block_type == 'members') $res['fields']['link_title']['edited'] = true;
            if ($model->block_type == 'members') $res['fields']['link']['edited'] = true;

            if ($model->block_type == 'advantages') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'advantages') $res['fields']['text']['editor'] = 'textarea';

            if ($model->block_type == 'form') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'form') $res['fields']['form_type']['edited'] = true;
            if ($model->block_type == 'form') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'form') $res['fields']['text']['editor'] = 'textarea';
            if ($model->block_type == 'form') $res['fields']['video_id']['edited'] = true;
            if ($model->block_type == 'form') $res['fields']['link_title']['edited'] = true;
            if ($model->block_type == 'form') $res['fields']['success_text']['edited'] = true;

            if ($model->block_type == 'banner') $res['fields']['description']['edited'] = true;
            if ($model->block_type == 'banner') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'banner') $res['fields']['image_mobile']['edited'] = true;
            if ($model->block_type == 'banner') $res['fields']['link']['edited'] = true;
            if ($model->block_type == 'banner') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'banner_2') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'banner_2') $res['fields']['image_mobile']['edited'] = true;

            if ($model->block_type == 'action') $res['fields']['description']['edited'] = true;
            if ($model->block_type == 'action') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'action') $res['fields']['info']['edited'] = true;
            if ($model->block_type == 'action') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'news') $res['fields']['title_2']['edited'] = true;

            if ($model->block_type == 'text_seo') $res['fields']['title_2']['edited'] = true;

            if ($model->block_type == 'text_image') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'text_image') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'text_image') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'text_image_2') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'text_image_2') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'text_image_2') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'text_image_3') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'text_image_3') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'text_image_3') $res['fields']['video_title']['edited'] = true;
            if ($model->block_type == 'text_image_3') $res['fields']['video_id']['edited'] = true;

            if ($model->block_type == 'text_image_4') $res['fields']['description']['edited'] = true;
            if ($model->block_type == 'text_image_4') $res['fields']['image']['edited'] = true;
            if ($model->block_type == 'text_image_4') $res['fields']['image_mobile']['edited'] = true;
            if ($model->block_type == 'text_image_4') $res['fields']['link_title']['edited'] = true;
            if ($model->block_type == 'text_image_4') $res['fields']['link']['edited'] = true;

            if ($model->block_type == 'news') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'reviews') $res['fields']['link_title']['edited'] = true;

            if ($model->block_type == 'numbers') $res['fields']['description']['edited'] = true;

            if ($model->block_type == 'gallery_2') $res['fields']['description']['edited'] = true;

            if ($model->block_type == 'map') $res['fields']['show_title']['edited'] = true;

            if ($model->block_type == 'filials') $res['fields']['text']['edited'] = true;
            if ($model->block_type == 'filials') $res['fields']['link_title']['edited'] = true;

            $main = [
                'text',
                'slider',
                'services',
                'actions',
                'members',
                'advantages',
                'missions',
                'numbers',
                'buttons',
                'gallery',
                'gallery_2',
                'form',
                'reviews',
                'banner',
                'action',
                'news',
                'articles',
                'text_seo',
                'text_image',
                'text_image_2',
                'text_image_3',
                'text_image_4',
                'faq',
                'map',
                'filials',
                'links',
                'banner_2',
            ];
            $columns2 = [
                'banner_2',
                'links',
                'text',
            ];
            $res_items = [];
            $types = static::block_typeList();
            foreach ($types as $k => $v) {
                if ($model->page->template == 'main' && in_array($k, $main)) $res_items[$k] = $v;
                if ($model->page->template == '2columns' && in_array($k, $columns2)) $res_items[$k] = $v;
            }

            $res['fields']['block_type']['items'] = $res_items;
        }

        return $res;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        TagDependency::invalidate(Yii::$app->cache, ['page_blocks']);
    }

    public function getAdminTabs($url = false, $activeMenu = false)
    {
        $res = parent::getAdminTabs($url, $activeMenu);

        $result = [];
        $result['self'] = $res['self'];

        if ($this->block_type == 'slider') $result['slides'] = $res['slides'];
        if ($this->block_type == 'advantages') $result['advantages'] = $res['advantages'];
        if ($this->block_type == 'numbers') $result['numbers'] = $res['numbers'];
        if ($this->block_type == 'missions') $result['missions'] = $res['missions'];
        if ($this->block_type == 'buttons') $result['buttons'] = $res['buttons'];
        if ($this->block_type == 'links') $result['links'] = $res['links'];
        if ($this->block_type == 'gallery') $result['images'] = $res['images'];
        if ($this->block_type == 'gallery_2') $result['images'] = $res['images'];

        if (count($result) == 1) $result = [];

        return $result;
    }

    public function getActions_real() {
        return Action::find()->published()->active_by_dates()->ordered()->limit(10)->all();
    }

    public function getMemberDirects_real() {
        return MemberDirect::find()->published()->ordered()->all();
    }

    public function getMembers_real() {
        return Member::find()->published()->ordered()->all();
    }

    public function getNews_real() {
        return News::find()->published()->orderBy('date DESC')->limit(4)->all();
    }

    public function getArticles_real() {
        return Article::find()->published()->ordered()->limit(4)->all();
    }

    public function getReviews_real() {
        return RequestReview::find()->published()->orderBy('date DESC')->andWhere(['OR', ['member_id' => 0], ['member_id' => null], ['member_id' => '']])->limit(5)->all();
    }

    public function getFilials_real() {
        return Filial::find()->published()->ordered()->all();
    }
}