<?php
use app\models\Page;
use app\models\PageBlock;
use app\widgets\services\ServicesWidget;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="services">
    <?=ServicesWidget::widget([
        'only_popular' => $block->only_popular,
        'title' => $block->title,
        'title_class' => 'megatext_n',
        'default_type' => 'adult',
        'options' => [
            'link_title' => $block->link_title,
        ],
    ])?>
</section>