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
    <h1 class="services-detail__title h2-title"><?=$this->context->h1title?></h1>
</div>

<?php if (!empty($service->intro_image)) { ?>
    <section class="about<?=!empty($service->discount_price)?' about_banner':''?>">
        <div class="container">
            <div class="about__wrapper">
                <div class="about__container">
                    <div class="about__left wysiwyg">
                        <?=TextHelper::redactorText($service->intro_text, ['<h2>' => '<h2 class="about__title">'])?>
                    </div>
                    <div class="about__right">
                        <?php if (!empty($service->intro_image)) { ?>
                            <img class="about__image" src="<?=TextHelper::ImgUrl($service->intro_image_obj->doProp(800, 2000))?>" alt="<?=TextHelper::Alt($service->title)?>">
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if(!empty($service->discount_price)) { ?>
                <div class="about__discount">
                    <p class="about__discount__name bodytext_n_strong"><?=$service->discount_title?></p>
                    <p class="about__discount__price">
                        <span class="about__discount__price_new"><?=TextHelper::price($service->discount_price)?> ₽</span>
                        <?php if (!empty($service->discount_price_old)) { ?>
                            <span class="about__discount__price_old">вместо <?=TextHelper::price($service->discount_price_old)?> ₽</span>
                        <?php } ?>
                    </p>
                    <?php if (!empty($service->discount_button)) { ?>
                        <a class="btn btn_link_arrow btn_link_arrow_white bodytext_n_strong _open-popup" href="#" data-target-id="service_consult_detail4_<?=$service->id?>"><?=!empty($service->discount_button)?$service->discount_button:'Получить скидку'?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>

<div class="container">
    <section class="block-content">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="block-content__left wysiwyg">
            <?=$service->text?>
        </div>
        <div class="block-content__right">
            <?php if(!empty($service->price)) { ?>
                <div class="block-content__price">
                    <p class="bodytext_n">Стоимость процедуры</p>
                    <p class="megatext_s_strong"><?=$service->price_from?'от ':''?><span><?=$service->price?></span> ₽</p>
                </div>
            <?php } ?>
<!--            <button class="block-content__btn btn btn_primary _open-popup" data-target-id="appointment_service_detail_--><?php //=$service->id?><!--">Записаться на приём</button>-->
            <button class="block-content__btn btn btn_primary _medflex_popup" >Записаться на приём</button>

            <div class="cta-card">
                <div class="cta-card__wrapper">
                    <img class="cta-card__image" src="<?=TextHelper::ImgUrl(SystemSettings::getParam('service', 'consult_image', '/assets/front/img/content/test1.jpg', false, 4))?>" alt="<?=TextHelper::Alt(SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?'))?>">
                    <p class="cta-card__title megatext_s_strong"><?=SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?')?></p>
                    <p class="cta-card__text bodytext_l"><?=SystemSettings::getParam('service', 'consult_text', 'Оставьте нам свои данные и мы свяжемся с вами в ближайшее время')?></p>
                    <button class="cta-card__btn btn btn_secondary _medflex_popup" ><?=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?></button>

                </div>
            </div>
        </div>
    </section>
</div>

<?php if($service->prices) { ?>
    <section class="price-block">
        <div class="container">
            <h2 class="price-block__title">Стоимость приёма специалистов</h2>
            <ul class="price-block__list">
                <?php foreach($service->prices as $k => $price) { ?>
                    <li class="price-block__item<?=$k>9?' _hide':''?>">
                        <p class="price-block__item__name bodytext_n"><?=$price->title?></p>
                        <p class="price-block__item__cost bodytext_l_strong"><?=$price->price_from?'от ':''?><?=intval($price->price)?> ₽</p>
                    </li>
                <?php } ?>
            </ul>
            <div class="price-block__wrapper">
                <?php if(count($service->prices) > 10) { ?>
                    <button class="price-block__btn btn btn_secondary" data-count="10">Показать ещё</button>
                <?php } ?>
                <a href="<?=Yii::$app->urlManager->createUrl(['price/index'])?>" class="price-block__link btn btn_link_arrow">Смотреть все цены</a>
            </div>
        </div>
    </section>
<?php } ?>

<?=MembersWidget::widget([
    'only_lead' => false,
    'title' => !empty($service->members_title)?$service->members_title:'Врачи',
    'section_class' => 'doctors_wide',
    'ids' => $service->members_input,
    'options' => [
        'link_title' => 'Смотреть всех врачей',
    ],
    'template' => 'nofilter',
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
    'modal_id' => 'appointment_service_detail_' . $service->id,
    'pjax_id' => 'appointment_service_detail_' . $service->id,
    'form_class' => RequestAppointmentForm::class,
    'model' => new RequestAppointmentForm(['service_id' => $service->id]),
    'template' => 'form_1',
])?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'consult_services',
    'modal_id' => 'service_consult_detail3_'.$service->id,
    'pjax_id' => 'service_consult_detail3_'.$service->id,
    'form_class' => RequestConsultForm::class,
    'model' => new RequestConsultForm(['service_id' => $service->id]),
    'template' => 'form_1',
])?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'consult_services',
    'modal_id' => 'service_consult_detail4_'.$service->id,
    'pjax_id' => 'service_consult_detail4_'.$service->id,
    'form_class' => RequestConsultForm::class,
    'model' => new RequestConsultForm(['service_id' => $service->id]),
    'template' => 'form_1',
])?>
<?php $this->endBlock()?>