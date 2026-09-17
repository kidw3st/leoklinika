<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */

//Action::indexUrl()
?>

<?=$this->render('//components/actions', ['actions' => $block->actions_real, 'title' => $block->title, 'title_class' => 'megatext_n'])?>