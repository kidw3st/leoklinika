<?php
use app\helpers\base\TextHelper;

/**
 * @var \app\models\Member $item
 */
?>

<a href="<?=$item->selfUrl?>" class="doctors__item">
    <div class="doctors__item__top">
        <div class="doctors__item__image-wrapper">
            <?php if(!empty($item->image_video)) { ?>
                <img src="<?=TextHelper::ImgUrl($item->image_video)?>" alt="<?=TextHelper::Alt($item->title)?>" class="doctors__item__image">
            <?php } else { ?>
                <img src="<?=TextHelper::ImgUrl($item->image_obj->doCrop(320, 366))?>" alt="<?=TextHelper::Alt($item->title)?>" class="doctors__item__image">
            <?php } ?>

            <?php if (!empty($item->experience)) { ?>
                <p class="doctors__item__experience bodytext_s_strong">Стаж <?=$item->experience?> <?=TextHelper::getNumEnding($item->experience, ['год', 'года', 'лет'])?></p>
            <?php } ?>
            <div href="#" class="doctors__item__more">
                <svg class="icon">
                    <use xlink:href="#icon-arrow"></use>
                </svg>
            </div>
        </div>
        <p class="doctors__item__name bodytext_n_strong"><?=$item->title?></p>
        <?php if (!empty($item->description)) { ?>
            <p class="doctors__item__post bodytext_l_strong"><?=$item->description?></p>
        <?php } ?>
    </div>
    <div class="doctors__item__bottom">
        <object data="" type="">
          <?php if (!empty($item->medflex_id)) { ?>
            <a href="https://booking.medflex.ru?user=<?=$medflex_token?>&employeeId=<?=$item->medflex_id?>&source=4" target="_blank" class="doctors__item__sign-up btn btn_primary btn_primary_arrow bodytext_l_strong"><span>Записаться</span></a>  
          <?php } else { ?>   
            <a href="#" class="doctors__item__sign-up btn btn_primary btn_primary_arrow bodytext_l_strong _open-popup" data-target-id="appointment_member_<?=$item->id?>">
                <span>Записаться</span>
            </a>
          <?php } ?>
        </object>
        <p class="doctors__item__pseudolink">Подробнее</p>
    </div>
</a>