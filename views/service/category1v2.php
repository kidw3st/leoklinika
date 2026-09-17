<?php
use app\helpers\base\TextHelper;
use app\models\Filial;
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestConsultForm;
use app\models\SystemSettings;
use app\widgets\faq\FaqWidget;
use app\widgets\members\MembersWidget;
use app\widgets\services\ServicesWidget;

/* @var $this \yii\web\View */
/* @var $service \app\models\Service */
/* @var $reviews \app\models\RequestReview[] */
/* @var $actions \app\models\Action[] */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>

<div class="container">
    <h2 class="services-directions__title h2-title"><?=$this->context->h1title?></h2>
    <div class="page__wrapper page__wrapper--v2">
        <aside class="aside page__aside">
            <div class="aside__head">
                <span class="aside__title bodytext_n_strong">Направления приёма</span>
                <svg class="icon">
                    <use xlink:href="#icon-arrow1"></use>
                </svg>
            </div>
            <div class="aside__menu">
                <ul class="aside__menu__list">
                    <?php foreach ($service->subsections as $child) { ?>
                        <li class="aside__menu__item">
                            <a href="<?=$child->selfUrl?>" class="aside__menu__link bodytext_m"><?=$child->title?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </aside>
        <div class="page__main">
            <?php if($service->image_2) { ?>
                <section class="banner ">
                    <picture class="banner__image">
                        <?php if (!empty($service->image_3)) { ?>
                            <source class="banner__image_mobile" media="(max-width: 600px)" srcset="<?=TextHelper::ImgUrl($service->image_3_obj->doProp(600, 2000))?>">
                        <?php } else { ?>
                            <source class="banner__image_mobile" media="(max-width: 600px)" srcset="<?=TextHelper::ImgUrl($service->image_2_obj->doProp(600, 2000))?>">
                        <?php } ?>
                        <img class="banner__image_desktop" src="<?=TextHelper::ImgUrl($service->image_2_obj->doProp(976, 2000))?>" alt="<?=TextHelper::Alt($service->title)?>">
                    </picture>
                </section>
            <?php } ?>

            <section class="block-service-intro">
                <div class="block-service-intro__header">
                    <div class="block-service-intro__left wysiwyg">
                        <h5><?=$service->text_title?></h5>
                    </div>

                    <div class="block-service-intro__right">
                        <button class="block-service-intro__btn btn btn_primary _open-popup" data-target-id="appointment_service_detail_<?=$service->id?>">Записаться на приём</button>
                    </div>
                </div>

                <div class="block-service-intro__text wysiwyg">
                    <?=$service->text?>
                </div>

                <!-- Кнопка для мобильных устройств (скрыта по умолчанию) -->
                <div class="block-service-intro__mobile-btn">
                    <button class="block-service-intro__btn btn btn_primary _open-popup" data-target-id="appointment_service_detail_<?=$service->id?>">Записаться на приём</button>
                </div>
            </section>
        </div>
    </div>

    <?php if ($service->blocks_real) { ?>
        <?php foreach ($service->blocks_real as $block) { ?>
            <?=$this->render('blocks/'.$block->block_type, ['service' => $service, 'block' => $block]);?>
        <?php } ?>
    <?php } ?>
</div>

<?=MembersWidget::widget([
    'only_lead' => false,
    'title' => !empty($service->members_title)?$service->members_title:'Врачи',
    'section_class' => 'doctors_wide',
    'ids' => $service->members_input,
    'options' => [
        'link_title' => 'Смотреть всех врачей',
    ],
])?>

<?php if(!empty($service->related_services_input)) { ?>
    <?=ServicesWidget::widget([
        'title' => 'Сопутствующие услуги',
        'page_more' => true,
        'page_size' => 8,
        'template' => 'all_service_detail',
        'default_type' => false,
        'ids' => $service->related_services_input,
        'options' => [
            'pager_class' => 'services__btn btn btn_secondary',
        ],
    ])?>
<?php } ?>

<?=$this->render('//components/actions', ['actions' => $actions, 'title' => 'Специальные предложения', 'title_class' => ''])?>

<?php if(!empty($service->images_real)) { ?>
    <section class="gallery">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="gallery__head">
                    <h2 class="gallery__title">Галерея</h2>
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
                    <?php foreach($service->images_real as $image) { ?>
                        <div class="swiper-slide">
                            <img class="_open-media-popup" data-target-id="media-popup" data-content-src="<?=TextHelper::ImgUrl($image->image_obj->doProp(1920, 1080))?>" src="<?=TextHelper::ImgUrl($image->image_obj->doProp(1920, 1080))?>" alt="<?=TextHelper::Alt($image->title)?>"/>
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

<?php if(!empty($service->videos_real)) { ?>
    <section class="gallery">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="gallery__head">
                    <h2 class="gallery__title">Видео по теме</h2>
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
                    <?php foreach ($service->videos_real as $video) { ?>
                        <div class="swiper-slide">
                            <div class="video video_open  _open-media-popup" data-target-id="media-popup" data-content-type="video" data-content-src="<?=TextHelper::ImgUrl($video->video)?>">
                                <div class="video__block">
                                    <div class="video__overlay">
                                        <img src="<?=TextHelper::ImgUrl($video->image_obj->doProp(1920, 1080))?>" alt="<?=TextHelper::Alt($video->title)?>" class="video__cover">
                                        <button class="btn video__btn">
                                            <img src="/assets/front/img/icons/icon-play.svg" alt="">
                                        </button>
                                    </div>
                                </div>
                            </div>
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

<?=$this->render('//components/reviews', ['title' => 'Отзывы пациентов о нашей работе', 'title_class' => '', 'reviews' => $reviews, 'link_title' => ''])?>

<?=$this->render('//components/form_inline', [
    'form_type' => 'consult_services',
    'pjax_id' => 'service_consult_detail2_'.$service->id,
    'model' => new RequestConsultForm(['service_id' => $service->id]),
    'form_class' => RequestConsultForm::class,
    'template' => 'consult',
    'section_class' => 'consultation_thin',
    'options' => [],
])?>

<?=FaqWidget::widget([
    'title' => 'Часто задаваемые вопросы',
    'service_id' => $service->id,
])?>

<section class="seo wysiwyg">
    <div class="container">
        <div class="seo__wrapper _toggle">
            <?php if(!empty($service->title_seo)) { ?>
                <h1 class="seo__title"><?=$service->title_seo?></h1>
            <?php } ?>
            <?php if (!empty($service->text_seo)) { ?>
                <?=TextHelper::redactorText($service->text_seo, ['<p>' => '<p class="seo__text bodytext_l">'])?>
            <?php } ?>
            <?php if(!empty($service->text_spoiler)) { ?>
                <div class="_toggle__container"><?=$service->text_spoiler?></div>
                <button class="seo__btn _toggle__button">
                    <span class="seo__btn__more">Показать ещё</span>
                    <span class="seo__btn__less">Свернуть</span>
                    <svg class="icon" width="24" height="24">
                        <use xlink:href="#icon-arrow1"></use>
                    </svg>
                </button>
            <?php } ?>
        </div>
    </div>
</section>

<?php $this->beginBlock('modal-appointment_service_detail_'.$service->id)?>
<?=$this->render('//components/form_modal', [
    'form_type' => 'appointment',
    'modal_id' => 'appointment_service_detail_' . $service->id,
    'pjax_id' => 'appointment_service_detail_' . $service->id,
    'form_class' => RequestAppointmentForm::class,
    'model' => new RequestAppointmentForm(['service_id' => $service->id]),
    'template' => 'form_1',
])?>
<?php $this->endBlock()?>