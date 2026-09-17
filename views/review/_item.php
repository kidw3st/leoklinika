<?php

/**
 * @var $review \app\models\RequestReview
 */
?>

<div class="reviews__item">
    <div class="reviews__item__head">
        <p class="reviews__item__author bodytext_n_strong"><?=$review->name?></p>
        <?php if($review->rating) { ?>
            <div class="reviews__item__grade">
                <svg class="icon">
                    <use xlink:href="#icon-star"></use>
                </svg>
                <span class="bodytext_n_strong"><?=number_format($review->rating, 1, '.', '')?></span>
            </div>
        <?php } ?>
    </div>
    <p class="reviews__item__text bodytext_l"><?=$review->text?></p>
    <div class="reviews__item__bottom">
        <?php if (!empty($review->source)) { ?>
            <a href="<?=$review->source?>" class="reviews__item__source bodytext_m_strong" target="_blank">Смотреть отзыв в источнике</a>
        <?php } ?>
    </div>
    <?php if ($review->member) { ?>
        <p class="reviews__item__doctor bodytext_m">Отзыв о приеме <a href="<?=$review->member->selfUrl?>" class="reviews__item__doctor__link"><?=$review->member->title?></a></p>
    <?php } ?>
    <?php if (!empty($review->date)) { ?>
        <p class="reviews__item__date bodytext_m"><?=$review->date_obj->format('d.m.Y')?></p>
    <?php } ?>
</div>