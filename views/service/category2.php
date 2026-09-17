<?php
use app\helpers\base\TextHelper;
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
    <h1 class="services-directions__title h2-title"><?=$this->context->h1title?></h1>
    <div class="page__wrapper">
        <aside class="aside page__aside">
            <?php if (!empty($service->subsections)) { ?>
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
            <?php } ?>
        </aside>
        <div class="page__main">
            <?php if($service->image_2) { ?>
                <section class="banner">
                    <picture class="swiper-slide__image">
                        <?php if (!empty($service->image_3)) { ?>
                            <source media="(max-width: 600px)" srcset="<?=TextHelper::ImgUrl($service->image_3_obj->doProp(600, 2000))?>">
                        <?php } else { ?>
                            <source media="(max-width: 600px)" srcset="<?=TextHelper::ImgUrl($service->image_2_obj->doProp(600, 2000))?>">
                        <?php } ?>
                        <img class="swiper-slide__image__desktop" src="<?=TextHelper::ImgUrl($service->image_2_obj->doProp(976, 2000))?>" alt="<?=TextHelper::Alt($service->title)?>">
                    </picture>
                </section>
            <?php } ?>
            <section class="block-content">
                <div class="decor-spots">
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                </div>
                <div class="block-content__left wysiwyg"><?=$service->text?></div>
                <div class="block-content__right">
<!--                    <button class="block-content__btn btn btn_primary _open-popup" data-target-id="appointment_service_detail_--><?php //=$service->id?><!--">Записаться на приём</button>-->
                    <button class="block-content__btn btn btn_primary _medflex_popup" >Записаться на приём</button>

                    <div class="cta-card">
                        <div class="cta-card__wrapper">
                            <img class="cta-card__image" src="<?=TextHelper::ImgUrl(SystemSettings::getParam('service', 'consult_image', '/assets/front/img/content/test1.jpg', false, 4))?>" alt="<?=TextHelper::Alt(SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?'))?>">
                            <p class="cta-card__title megatext_s_strong"><?=SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?')?></p>
                            <p class="cta-card__text bodytext_l"><?=SystemSettings::getParam('service', 'consult_text', 'Оставьте нам свои данные и мы свяжемся с вами в ближайшее время')?></p>
<!--                        <button class="cta-card__btn btn btn_secondary _open-popup" data-target-id="service_consult_detail3_--><?php //=$service->id?><!--">--><?php //=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?><!--</button>-->
                            <button class="cta-card__btn btn btn_secondary _medflex_popup" ><?=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?></button>

                        </div>
                    </div>
                </div>
            </section>

            <?=MembersWidget::widget([
                'only_lead' => false,
                'title' => !empty($service->members_title)?$service->members_title:'Врачи',
                'section_class' => 'doctors_thin',
                'ids' => $service->members_input,
                'filter' => false,
                'options' => [
                    'link_title' => 'Смотреть всех врачей',
                ],
            ])?>

            <?php if(!empty($service->pricelist)) { ?>
                <section class="pricelist">
                    <div class="container">
                        <div class="pricelist__filter"></div>
                        <h2 class="pricelist__title">Стоимость приёма и процедур</h2>

                        <div class="pricelist__wrapper">
                            <?=$this->render('_pricelist_accordion', ['pricelist' => $service->pricelist])?>
                        </div>

                        <a class="pricelist__more btn btn_link_arrow bodytext_n_strong" href="<?=Yii::$app->urlManager->createUrl(['price/index'])?>">Смотреть все цены</a>
                    </div>
                </section>
            <?php } ?>

            <?=$this->render('//components/form_inline', [
                'form_type' => 'consult_services',
                'pjax_id' => 'service_consult_detail_'.$service->id,
                'model' => new RequestConsultForm(['service_id' => $service->id]),
                'form_class' => RequestConsultForm::class,
                'template' => 'consult',
                'section_class' => 'consultation_thin',
                'options' => [
                    'title_tag' => 'h5',
                ]
            ])?>
        </div>
    </div>
</div>

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
    'section_class' => 'consultation_wide',
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
        'form_image' => '',
        'form_video_id' => '',
        'modal_id' => 'appointment_service_detail_' . $service->id,
        'pjax_id' => 'appointment_service_detail_' . $service->id,
        'form_class' => RequestAppointmentForm::class,
        'model' => new RequestAppointmentForm(['service_id' => $service->id]),
        'template' => 'form_1',
    ])?>

    <?=$this->render('//components/form_modal', [
        'form_type' => 'consult_services',
        'form_image' => '',
        'form_video_id' => '',
        'modal_id' => 'service_consult_detail3_'.$service->id,
        'pjax_id' => 'service_consult_detail3_'.$service->id,
        'form_class' => RequestConsultForm::class,
        'model' => new RequestConsultForm(['service_id' => $service->id]),
        'template' => 'form_1',
    ])?>
<?php $this->endBlock()?>