<?php
use app\models\Action;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="about__quote">
    <div class="container">
        <div class="about__quote__title megatext_l"><?=$block->title?></div>
        <?php if (!empty($block->title_2)) { ?>
            <div class="about__quote__right">
                <h5 class="about__quote__text"><?=$block->title_2?></h5>
            </div>
        <?php } ?>
    </div>
</section>