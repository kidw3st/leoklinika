<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="job">
    <div class="container">
        <div class="job__container">
            <div class="job__left">
                <h2 class="job__title"><?=$block->title?></h2>
                <div class="job__text bodytext_l"><?=$block->description?></div>
                <?php if(!empty($block->link)) { ?>
                    <a class="btn btn_primary bodytext_l_strong" href="<?=$block->link?>"><?=!empty($block->link_title)?$block->link_title:'Смотреть'?></a>
                <?php } ?>
            </div>
            <div class="job__right">
                <picture class="job__image">
                    <source media="(max-width: 480px)" srcset="<?=TextHelper::ImgUrl($block->image_mobile)?>">
                    <img src="<?=TextHelper::ImgUrl($block->image)?>" alt="<?=TextHelper::Alt($block->title)?>">
                </picture>
            </div>
        </div>
    </div>
</section>