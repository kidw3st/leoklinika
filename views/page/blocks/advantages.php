<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="advantages">
    <div class="container">
        <div class="advantages__bg">
            <img src="/assets/front/img/content/adv-bg.svg" alt="<?=TextHelper::Alt($block->title)?>" class="advantages__bg__image">
        </div>
        <div class="advantages__bg">
            <div class="decor-spots">
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
            </div>
        </div>
        <div class="advantages__left">
            <p class="advantages__title megatext_n"><?=$block->title?></p>
            <h5 class="advantages__text"><?=$block->text?></h5>
        </div>
        <div class="advantages__right">
            <ul class="advantages__list">
                <?php foreach ($block->advantages_real as $advantage) { ?>
                    <li class="advantages__item">
                        <img src="<?=TextHelper::ImgUrl($advantage->icon_obj->doCrop(136, 136))?>" alt="<?=TextHelper::Alt($advantage->title)?>" class="advantages__item__image">
                        <p class="advantages__item__text megatext_s_strong"><?=$advantage->title?></p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>