<?php
use app\helpers\base\TextHelper;

/**
 * @var \app\models\Action $action
 */
?>

<a href="<?=$action->selfUrl?>" class="promos__item">
    <div class="promos__item__left">
        <div class="promos__item__wrapper">
            <h5 class="promos__item__title"><?=$action->title?></h5>
            <?php if(!empty($action->price)) { ?>
                <p class="promos__item__price">
                    <span class="promos__item__price__new"><?=TextHelper::price($action->price)?> ₽</span>
                    <?php if(!empty($action->price_old)) { ?>
                        <span class="promos__item__price__old"><?=TextHelper::price($action->price_old)?> ₽</span>
                    <?php } ?>
                </p>
            <?php } ?>
        </div>
        <?php if(!empty($action->active_to)) { ?>
            <p class="promos__item__deadline bodytext_l">
                Действует до <span class="promos__item__deadline__date"><?=$action->active_to_obj->format('d.m.Y')?></span>
            </p>
        <?php } ?>
    </div>
    <div class="promos__item__right">
        <picture class="promos__item__image">
            <source media="(max-width: 768px)" srcset="<?=TextHelper::ImgUrl($action->image_obj->doCrop(443, 468))?>">
            <img src="<?=TextHelper::ImgUrl($action->image_obj->doCrop(443, 468))?>" alt="<?=TextHelper::Alt($action->title)?>" class="promos__item__image__desktop">
        </picture>
    </div>
</a>