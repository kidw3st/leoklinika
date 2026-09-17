<?php
use app\helpers\base\TextHelper;
use app\models\Article;
use app\models\forms\RequestAppointmentForm;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if(!empty($block->filials_real)) {?>
    <section class="clinics">
        <div class="container">
            <div class="clinics__wrapper">
                <div class="clinics__container">

                    <div class="clinics__left">
                        <h2 class="clinics__title"><?=$block->title?></h2>
                        <div class="wysiwyg"><?=$block->text?></div>

                        <button class="btn btn_primary bodytext_n_strong _medflex_popup"><?=empty($block->link_title)?'Записаться на прием':$block->link_title?></button>
                    </div>

                    <div class="clinics__right">
                        <div class="clinics__list">
                            <?php foreach ($block->filials_real as $filial) { ?>
                                <div class="clinics__item _open-popup" data-target-id="filial_<?=$filial->id?>">
                                    <img class="clinics__image" src="<?=TextHelper::ImgUrl(!empty($filial->images_real[0])?$filial->images_real[0]->image_obj->doProp(659, 2000):'/assets/front/img/content/clinics.png')?>" alt="<?=TextHelper::Alt($filial->title)?>">
                                    <span class="clinics__name megatext_s_strong"><?=$filial->title?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $this->beginBlock('modal-filials_block_'.$block->id)?>
    <?=$this->render('//components/form_modal', [
        'form_type' => 'appointment_page_block',
        'modal_id' => 'filials_block_' . $block->id,
        'pjax_id' => 'filials_block_' . $block->id,
        'form_class' => RequestAppointmentForm::class,
        'model' => new RequestAppointmentForm(['block_id' => $block->id]),
        'template' => 'form_1',
    ])?>

    <?php foreach ($block->filials_real as $filial) { ?>
        <div id="filial_<?=$filial->id?>" class="popup popup_clinic">
            <div class="popup__wrapper">
                <div class="popup__close-area"></div>
                <div class="popup__block">
                    <button class="popup__close">
                        <svg class="popup__close__icon icon">
                            <use xlink:href="#icon-close"></use>
                        </svg>
                    </button>
                    <div class="popup__content">
                        <div class="popup__content__wrapper">
                            <div class="popup__content__head">
                                <h5 class="popup__content__title"><?=$filial->title?></h5>
                                <div class="popup__content__contacts">
                                    <p class="bodytext_l popup__content__contacts__address"><?=$filial->address?></p>
                                    <?php if(!empty($filial->phones_arr[0])) { ?>
                                        <a class="bodytext_l popup__content__contacts__phone" href="tel:<?=TextHelper::tel($filial->phones_arr[0])?>"><?=$filial->phones_arr[0]?></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if(!empty($filial->images_real)) { ?>
                                <div class="popup__gallery">
                                    <div class="swiper _gallery-2">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($filial->images_real as $image) { ?>
                                                <div class="swiper-slide">
                                                    <img src="<?=TextHelper::ImgUrl($image->image_obj->doProp(1920, 1080))?>" alt="<?=TextHelper::Alt($image->title)?>"/>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="swiper-navigation">
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-arrows">
                                                <div class="swiper-button swiper-button-prev">
                                                    <svg class="icon">
                                                        <use xlink:href="#icon-arrow2"></use>
                                                    </svg>
                                                </div>
                                                <div class="swiper-button swiper-button-next">
                                                    <svg class="icon">
                                                        <use xlink:href="#icon-arrow2"></use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div thumbsSlider="" class="swiper _gallery-1">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($filial->images_real as $image) { ?>
                                                <div class="swiper-slide">
                                                    <img src="<?=TextHelper::ImgUrl($image->image_obj->doCrop(132, 81))?>" alt="<?=TextHelper::Alt($image->title)?>"/>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $this->endBlock()?>
<?php } ?>