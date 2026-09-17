<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */
?>

<?php if ($block->items_real) { ?>
    <section class="actions">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="container">
            <?php foreach ($block->items_real as $item) { ?>
                <a href="<?=$item->link?>" class="actions__item actions__item_<?=$item->block_color?>" style="background-image: url('<?=$item->image?>');">
                    <div class="actions__item__text-wrapper">
                        <p class="actions__item__title megatext_s megatext_s_strong"><?=$item->title?></p>
                        <p href="#" class="actions__item__pseudolink btn btn_link_arrow btn_link_arrow_white"><?=$item->getLink_title()?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </section>
<?php } ?>