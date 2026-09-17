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

<section class="licenses">
    <div class="container">
        <div class="licenses__inner">
            <picture>
                <source srcset="<?=TextHelper::ImgUrl($block->image_mobile)?>" media="(max-width: 480px)">
                <img src="<?=TextHelper::ImgUrl($block->image)?>" alt="<?=TextHelper::Alt($block->title)?>" class="licenses__bg">
            </picture>
            <img src="/assets/front/img/decor/licenses.svg" alt="<?=TextHelper::Alt($block->title)?>" class="licenses__decor">
            <div class="licenses__content">
                <h2 class="licenses__title megatext_n"><?=$block->title?></h2>
                <p class="licenses__text bodytext_n"><?=$block->description?></p>
                <?php if ($block->link) { ?>
                    <a href="<?=$block->link?>" class="btn btn_primary bodytext_n_strong"><?=empty($block->link_title)?'Читать подробнее':$block->link_title?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>