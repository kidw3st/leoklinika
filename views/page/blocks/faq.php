<?php
use app\models\Page;
use app\models\PageBlock;
use app\widgets\faq\FaqWidget;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?=FaqWidget::widget([
    'title' => $block->title,
    'title_class' => 'megatext_n',
])?>