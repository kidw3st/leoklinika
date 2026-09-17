<?php

/* @var $this \yii\web\View */
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestConsultForm;
use app\models\SystemSettings;
use app\widgets\members\MembersWidget;
use yii\helpers\ArrayHelper;

/* @var \app\models\Action $action  */
/* @var \app\models\Action[] $actions  */
/* @var \app\models\ActionAdvantage[] $advantages  */
/* @var string $phone  */
/* @var string $title_advantages  */
/* @var string $title_images  */
/* @var string $title_members  */
/* @var array $member_ids  */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<div class="container">
    <div class="promos-detail__banner">
        <div class="promos-detail__left">
            <picture class="promos-detail__image">
                <source media="(max-width: 768px)" srcset="<?=TextHelper::ImgUrl($action->image_banner_obj->doProp(768, 1000))?>">
                <img src="<?=TextHelper::ImgUrl($action->image_banner_obj->doProp(10000, 10000))?>" alt="<?=TextHelper::Alt($action->title)?>">
            </picture>
        </div>

        <div class="promos-detail__right">
            <h1 class="promos-detail__title megatext_n"><?=$action->title?></h1>
            <p class="promos-detail__text bodytext_n"><?=$action->description?></p>
            <button class="btn btn_primary _open-popup bodytext_n_strong" data-target-id="appointment_action_detail_<?=$action->id?>"><?=$action->button?$action->button:'Записаться онлайн'?></button>
        </div>
    </div>


    <div class="promos-detail__container">
        <div class="promos-detail__info">
            <div class="promos-detail__info__list">
                <?php if(!empty($action->dates_str)) { ?>
                    <div class="promos-detail__info__item">
                        <div class="promos-detail__info__icon">
                            <svg class="icon">
                                <use xlink:href="#icon-calendar1"></use>
                            </svg>
                        </div>
                        <div class="promos-detail__info__box">
                            <div class="promos-detail__info__name bodytext_m_strong">Срок действия акции:</div>
                            <div class="promos-detail__info__value bodytext_n_strong"><?=$action->dates_str?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($action->profit)) { ?>
                    <div class="promos-detail__info__item">
                        <div class="promos-detail__info__icon">
                            <svg class="icon">
                                <use xlink:href="#icon-sale"></use>
                            </svg>
                        </div>
                        <div class="promos-detail__info__box">
                            <div class="promos-detail__info__name bodytext_m_strong">Ваша выгода</div>
                            <div class="promos-detail__info__value bodytext_n_strong"><?=$action->profit?></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($action->duration)) { ?>
                    <div class="promos-detail__info__item">
                        <div class="promos-detail__info__icon">
                            <svg class="icon">
                                <use xlink:href="#icon-clock1"></use>
                            </svg>
                        </div>
                        <div class="promos-detail__info__box">
                            <div class="promos-detail__info__name bodytext_m_strong">Продолжительность:</div>
                            <div class="promos-detail__info__value bodytext_n_strong"><?=$action->duration?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="promos-detail__sepatator"></div>
    <div class="promos-detail__container">
        <section class="block-content">
            <div class="decor-spots">
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
            </div>
            <div class="block-content__left wysiwyg">
                <?=$action->text?>
            </div>
            <div class="block-content__right">
                <?php if (!empty($action->price)) { ?>
                    <div class="block-content__price">
                        <p class="bodytext_n">Стоимость процедуры со скидкой</p>
                        <p class="megatext_s_strong"><span><?=TextHelper::price($action->price)?></span> ₽</p>
                    </div>
                <?php } ?>
<!--                <button class="block-content__btn btn btn_primary _open-popup bodytext_n_strong" data-target-id="appointment_action_detail_--><?php //=$action->id?><!--">Записаться на приём</button>-->
                <button class="block-content__btn btn btn_primary  bodytext_n_strong _medflex_popup" >Записаться на приём</button>
                <div class="cta-card">
                    <div class="cta-card__wrapper">
                        <img class="cta-card__image" src="<?=TextHelper::ImgUrl(SystemSettings::getParam('service', 'consult_image', '/assets/front/img/content/test1.jpg', false, 4))?>" alt="<?=TextHelper::Alt(SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?'))?>">
                        <p class="cta-card__title megatext_s_strong"><?=SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?')?></p>
                        <p class="cta-card__text bodytext_l"><?=SystemSettings::getParam('service', 'consult_text', 'Оставьте нам свои данные и мы свяжемся с вами в ближайшее время')?></p>
<!--                        <button class="cta-card__btn btn btn_secondary _open-popup" data-target-id="action_consult_detail3_--><?php //=$action->id?><!--">--><?php //=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?><!--</button>-->
                        <button class="cta-card__btn btn btn_secondary _medflex_popup" ><?=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?></button>

                    </div>
                </div>
            </div>
        </section>

        <?php if($advantages) { ?>
            <div class="promos-detail__advantages">
                <div class="decor-spots">
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                </div>
                <h2 class="promos-detail__advantages__title"><?=$title_advantages?></h2>

                <div class="promos-detail__advantages__list">
                    <?php foreach ($advantages as $advantage) { ?>
                        <div class="promos-detail__advantages__item">
                            <div class="promos-detail__advantages__name bodytext_n_strong"><?=$advantage->title?></div>
                            <div class="promos-detail__advantages__text bodytext_l"><?=$advantage->text?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php if(!empty($action->images_real)) { ?>
    <section class="gallery">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="gallery__head">
                    <h2 class="gallery__title"><?=$title_images?></h2>
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
                    <?php foreach($action->images_real as $image) { ?>
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

<?php if(!empty($member_ids)) { ?>
    <?=MembersWidget::widget([
        'only_lead' => false,
        'title' => $title_members,
        'section_class' => 'doctors_wide',
        'template' => 'nofilter',
        'ids' => $member_ids,
        'options' => [
            'link_title' => 'Смотреть всех врачей',
        ],
    ])?>
<?php } ?>

<div class="promos-detail__container">
    <?=$this->render('//components/form_inline', [
        'form_type' => 'consult_action',
        'form_image' => '',
        'form_video_id' => '',
        'pjax_id' => 'consult_action_'.$action->id,
        'model' => new RequestConsultForm(['action_id' => $action->id]),
        'form_class' => RequestConsultForm::class,
        'template' => 'consult',
        'section_class' => 'consultation_wide',
        'options' => [],
    ])?>

    <section class="phone-block">
        <div class="container">
            <div class="phone-block__inner">
                <h5 class="phone-block__title"><?=SystemSettings::getParam('actions', 'phone_text', 'Или звоните нам прямо сейчас')?> </h5>
                <div class="phone-block__phone">
                    <div class="phone-block__icon">
                        <svg class="icon">
                            <use xlink:href="#icon-phone1"></use>
                        </svg>
                    </div>
                    <a class="megatext_n" href="tel:<?=TextHelper::tel($phone)?>"><?=$phone?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="note">
        <div class="container">
            <div class="note__wrapper">
                <div class="note__content bodytext_n wysiwyg">
                    <?=$action->text_2?>
                </div>
            </div>
        </div>
    </section>
</div>

<?=$this->render('//components/actions', ['actions' => $actions, 'title' => 'Специальные предложения', 'title_class' => ''])?>

<?php $this->beginBlock('modal-appointment_action_detail_'.$action->id)?>
    <?=$this->render('//components/form_modal', [
        'form_type' => 'appointment_action_detail',
        'form_image' => '',
        'form_video_id' => '',
        'modal_id' => 'appointment_action_detail_' . $action->id,
        'pjax_id' => 'appointment_action_detail_' . $action->id,
        'form_class' => RequestAppointmentForm::class,
        'model' => new RequestAppointmentForm(['action_id' => $action->id]),
        'template' => 'form_1',
    ])?>

    <?=$this->render('//components/form_modal', [
        'form_type' => 'consult_action',
        'form_image' => '',
        'form_video_id' => '',
        'modal_id' => 'action_consult_detail3_'.$action->id,
        'pjax_id' => 'action_consult_detail3_'.$action->id,
        'form_class' => RequestConsultForm::class,
        'model' => new RequestConsultForm(['action_id' => $action->id]),
        'template' => 'form_1',
    ])?>
<?php $this->endBlock()?>