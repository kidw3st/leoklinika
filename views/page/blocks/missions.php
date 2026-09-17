<?php
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if($block->missions_real) { ?>
    <section class="mission">
        <div class="container">
            <div class="mission__list">
                <?php foreach($block->missions_real as $mission) { ?>
                    <div class="mission__item">
                        <div class="mission__icon">
                            <svg class="icon">
                                <use xlink:href="#icon-mission"></use>
                            </svg>
                        </div>
                        <div class="mission__title megatext_s_strong"><?=$mission->title?></div>
                        <div class="mission__text bodytext_l"><?=$mission->text?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>