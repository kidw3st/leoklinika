<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if ($block->slides_real) { ?>
    <section class="main-slider">
        <div class="container">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($block->slides_real as $slide) { ?>
                        <div class="swiper-slide">
                            <picture class="swiper-slide__image">
                                <?php if(!empty($slide->image_mobile)) { ?>
                                    <source media="(max-width: 768px)" srcset="<?=TextHelper::ImgUrl($slide->image_mobile_obj->doProp(1642, 779))?>">
                                <?php } else { ?>
                                    <source media="(max-width: 768px)" srcset="<?=TextHelper::ImgUrl($slide->image_obj->doProp(1642, 779))?>">
                                <?php } ?>
                                <img class="swiper-slide__image__desktop" src="<?=TextHelper::ImgUrl($slide->image_obj->doProp(1642, 779))?>" alt="<?=TextHelper::Alt($slide->title)?>">
                            </picture>
                            <div class="swiper-slide__content">
                                <?php if (!empty($slide->title)) { ?>
                                    <p class="swiper-slide__title megatext_l" data-swiper-parallax="-100" data-swiper-parallax-opacity="0.5"><?=$slide->title?></p>
                                <?php } ?>
                                <?php if (!empty($slide->text)) { ?>
                                    <p class="swiper-slide__text megatext_s" data-swiper-parallax="-200"><?=$slide->text?></p>
                                <?php } ?>
                                <?php if (!empty($slide->link)) { ?>
                                    <a href="<?=$slide->link?>" class="btn btn_primary" data-swiper-parallax="-300"><?=empty($slide->link_title)?'Подробнее':$slide->link_title?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation">
                    <div class="swiper-arrows">
                        <button class="swiper-button swiper-button-prev button">
                            <svg class="icon">
                                <use xlink:href="#icon-arrow"></use>
                            </svg>
                        </button>
                        <button class="swiper-button swiper-button-next button">
                            <svg class="icon">
                                <use xlink:href="#icon-arrow"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
<?php } ?>
