<?php
use app\models\Action;
use app\models\Page;
use app\models\PageBlock;
use app\models\RequestReview;
use app\models\ReviewRating;

/**
 * @var RequestReview[] $reviews
 * @var string $title
 * @var string $link_title
 * @var string $title_class
 * @var ReviewRating[] $socials
 */
?>

<?php if ($reviews) { ?>
    <section class="reviews">
        <div class="container">
            <h2 class="reviews__title <?=$title_class?>"><?=$title?></h2>
            <div class="reviews__slider">
                <div class="swiper swiper_template">

                    <div class="swiper-wrapper">
                        <?php foreach ($reviews as $review) { ?>
                            <div class="swiper-slide">
                                <?=$this->render('//review/_item', ['review' => $review])?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="reviews__slider__footer">
                        <div class="swiper-navigation">
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
                            <div class="swiper-pagination"></div>
                        </div>

                        <a class="reviews__slider__link btn btn_link_arrow bodytext_n_strong" href="<?=RequestReview::indexUrl()?>"><?=!empty($link_title)?$link_title:'Смотреть все отзывы'?></a>
                    </div>
                </div>
            </div>

            <?=$this->render('//review/_socials', ['class' => 'reviews__rating'])?>
        </div>
    </section>
<?php } ?>