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
    <section class="gallery">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="gallery__head">
                    <h2 class="gallery__title"><?=$block->title?></h2>
                    <div class="swiper-navigation _desktop">
                        <div class="swiper-arrows">
                            <button class="swiper-button swiper-button-prev button">
                                <svg class="icon">
                                    <use xlink:href="#icon-arrow2"></use>
                                </svg>
                            </button>
                            <button class="swiper-button swiper-button-next button">
                                <svg class="icon">
                                    <use xlink:href="#icon-arrow2"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="swiper-wrapper" data-media-group>
                    <?php foreach ($block->images_real as $image) { ?>
                        <div class="swiper-slide">
                            <?php if(!empty($image->video)) { ?>
                                <div class="video video_open  _open-media-popup" data-target-id="media-popup" data-content-type="video" data-popup-class="popup_media_with_text" data-content-src="<?=TextHelper::ImgUrl($image->video->video)?>">
                                    <div class="video__block">
                                        <div class="video__overlay">
                                            <img src="<?=TextHelper::ImgUrl($image->image_obj->doProp(440, 2000))?>" alt="video__cover" class="video__cover">
                                            <button class="btn video__btn">
                                                <img src="/assets/front/img/icons/icon-play.svg" alt="">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <img class="_open-media-popup" data-target-id="media-popup" data-popup-class="popup_media_with_text" data-content-src="<?=TextHelper::ImgUrl($image->image_obj->doProp(1920, 1080))?>" src="<?=TextHelper::ImgUrl($image->image_obj->doProp(440, 2000))?>" />
                            <?php } ?>
                            <?php if(!empty($image->title)) { ?>
                                <div class="gallery__name bodytext_n_strong"><?=$image->title?></div>
                            <?php } ?>
                            <?php if(!empty($image->text)) { ?>
                                <div class="gallery__text"><?=$image->text?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation _adaptive">
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>