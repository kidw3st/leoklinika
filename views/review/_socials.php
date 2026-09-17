<?php
use app\models\Action;
use app\models\Page;
use app\models\PageBlock;
use app\models\RequestReview;
use app\models\ReviewRating;

/**
 * @var $class string
 */

$socials = ReviewRating::find()->published()->ordered()->limit(3)->all();
?>

<?php if ($socials) { ?>
    <div class="rating rating_<?=(count($socials)==3)?3:2?> <?=$class?>">
        <p class="rating__title">Независимые рейтинги</p>
        <div class="rating__wrapper">
            <?php foreach ($socials as $social) { ?>
                <a href="<?=$social->link?>" class="rating__item rating__item_<?=$social->type?>" target="_blank" rel="nofollow">
                    <div class="rating__item__grade">
                        <svg class="icon">
                            <use xlink:href="#icon-star2"></use>
                        </svg>
                        <span><?=$social->rating?></span>
                    </div>
                    <div class="rating__item__logo">
                        <svg class="icon">
                            <use xlink:href="#icon-<?=$social->type?>"></use>
                        </svg>
                    </div>
                    <p class="rating__item__name"><?=$social->type_val?></p>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>