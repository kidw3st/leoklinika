<?php

namespace app\widgets\members;

use app\components\base\CActiveRecord;
use app\helpers\base\SystemHelper;
use app\models\Member;
use app\models\MemberDirect;
use app\models\Service;
use app\models\ServiceTag;
use Yii;
use yii\helpers\ArrayHelper;

class MembersWidget extends \yii\base\Widget {
    public $title;
    public $only_lead;
    public $section_class = '';
    public $ids = false;
    public $title_class = '';
    public $template = 'index';
    public $options = [];
    public $filter = true;
    public $link_all = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $current_tag = Yii::$app->request->get('tag', false);

        $criteria = Member::find()->published()->ordered()->joinWith('directs', false);
        if ($this->only_lead) $criteria->andWhere(['member.is_lead' => 1]);
        if ($this->ids) $criteria->andWhere(['member.id' => $this->ids]);
        $criteria_tags = clone $criteria;

        if ($current_tag) $criteria->andWhere(['member_direct.id' => $current_tag]);

        $tags = [];
        $member_ids = ArrayHelper::getColumn($criteria_tags->all(), 'id');
        if (!empty($member_ids)) {
            $tag_ids = Yii::$app->db->createCommand('SELECT direct_id FROM member2direct WHERE member_id IN (' . implode(', ', $member_ids) . ') GROUP BY direct_id')->queryAll();
            $tag_ids = ArrayHelper::getColumn($tag_ids, 'direct_id');
            $tags = MemberDirect::find()->where(['id' => $tag_ids])->ordered()->published()->all();
        }

        $members = $criteria->limit(16)->all();
        if (!$members) return '';

        return $this->render($this->template, [
            'title' => $this->title,
            'link_all' => !empty($this->link_all)?$this->link_all:Member::indexUrl(),
            'tags' => $tags,
            'members' => $members,
            'current_tag' => $current_tag,
            'section_class' => $this->section_class,
            'pjax_id' => 'services_' . $this->id,
            'filter' => $this->filter,
            'options' => $this->options,
        ]);
    }
}