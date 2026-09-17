<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if($block->images_real) { ?>
    <div class="container">
        <section class="documents__wrapper">
            <p class="documents__text bodytext_l"><?=$block->description?></p>
            <div class="documents__list" data-media-group>
                <?php foreach ($block->images_real as $image) { ?>
                    <div class="documents__item">
                        <img class="documents__image _open-media-popup" data-target-id="media-popup" data-content-src="<?=TextHelper::ImgUrl($image->image)?>" src="<?=TextHelper::ImgUrl($image->image_obj->doProp(251, 2000))?>" />
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>
<?php } ?>