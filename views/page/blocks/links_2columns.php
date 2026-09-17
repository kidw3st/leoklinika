<?php
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if($block->links_real) { ?>
    <div class="block-content__list">
        <?php foreach($block->links_real as $link) { ?>
            <a href="<?=$link->link?>" class="block-content__link bodytext_n"><?=$link->title?></a>
        <?php } ?>
    </div>
<?php } ?>