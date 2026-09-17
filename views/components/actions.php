<?php
use app\helpers\base\TextHelper;

/**
 * @var \app\models\Action[] $actions
 * @var string $title
 * @var string $title_class
 */

//Action::indexUrl()
?>

<?php if (!empty($actions)) { ?>
    <section class="promos">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="promos__head">
                    <h2 class="promos__title <?=$title_class?>"><?=$title?></h2>
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
                <div class="swiper-wrapper">
                    <?php foreach ($actions as $action) { ?>
                        <div class="swiper-slide">
                            <?=$this->render('//actions/_item', ['action' => $action])?>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation _mobile">
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>