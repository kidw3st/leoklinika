<?php
use app\helpers\base\TextHelper;
use app\models\Action;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="documents__wrapper">
    <div class="container">
        <div class="banner _desktop">
            <picture class="banner__image">
                <source srcset="<?=TextHelper::ImgUrl($block->image_mobile)?>" media="(max-width: 480px)">
                <img class="banner__image" src="<?=TextHelper::ImgUrl($block->image)?>" alt="<?=TextHelper::Alt($block->title)?>">
            </picture>
        </div>
    </div>
</section>