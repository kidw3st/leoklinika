<?php
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="counters">
    <div class="decor-spots">
        <div class="decor-spots__item"></div>
        <div class="decor-spots__item"></div>
        <div class="decor-spots__item"></div>
    </div>
    <div class="container">
        <div class="counters__wrapper">
            <div class="counters__container">
                <div class="counters__left">
                    <h2 class="counters__title"><?=$block->title?></h2>
                    <h5 class="counters__text"><?=$block->description?></h5>
                </div>
                <div class="counters__right">
                    <?php if($block->numbers_real) { ?>
                        <div class="counters__list">
                            <?php foreach ($block->numbers_real as $number) { ?>
                                <div class="counters__item">
                                    <div class="counters__value megatext_l"><?=$number->number?></div>
                                    <div class="counters__name bodytext_n_strong"><?=$number->title?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>