<?php
use app\models\Action;
use app\models\Page;
use app\models\PageBlock;
use app\models\RequestReview;
use app\models\ReviewRating;

/**
 * @var Page $item
 * @var PageBlock $block
 */

?>

<?=$this->render('//components/reviews', ['title' => $block->title, 'title_class' => 'megatext_n', 'reviews' => $block->reviews_real, 'link_title' => 'Смотреть все отзывы'])?>