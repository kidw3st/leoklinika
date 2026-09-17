<?php
use app\helpers\base\TextHelper;
use app\models\Action;
use app\models\forms\RequestAppointmentForm;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="info">
    <div class="container">
        <div class="info__wrapper">
            <div class="info__container">

                <div class="info__left">
                    <img class="info__image" src="<?=TextHelper::ImgUrl($block->image_obj->doProp(628, 2000))?>" alt="<?=TextHelper::Alt($block->title)?>">
                </div>

                <div class="info__right">
                    <div class="wysiwyg">
                        <?=$block->text?>
                    </div>

                    <?php if($block->video) { ?>
                        <div class="info__video _open-media-popup" data-target-id="media-popup" data-content-src="<?=TextHelper::ImgUrl($block->video->video)?>" data-content-type="video">
                            <div class="info__video__icon">
                                <svg class="icon">
                                    <use xlink:href="#icon-play"></use>
                                </svg>
                            </div>
                            <span class="info__video__caption megatext_s_strong"><?=!empty($block->video_title)?$block->video_title:'Смотреть'?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>