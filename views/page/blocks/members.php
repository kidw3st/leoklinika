<?php
use app\models\Member;
use app\models\Page;
use app\models\PageBlock;
use app\widgets\members\MembersWidget;
use app\widgets\services\ServicesWidget;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?=MembersWidget::widget([
    'only_lead' => $block->only_lead,
    'section_class' => 'doctors_wide',
    'title' => $block->title,
    'link_all' => $block->link,
    'options' => [
        'link_title' => $block->link_title,
    ],
])?>