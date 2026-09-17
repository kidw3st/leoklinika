<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestConsultForm;
use app\models\forms\RequestReviewForm;
use app\models\SystemSettings;

/* @var $this \yii\web\View */
/* @var $member \app\models\Member */
/* @var $actions \app\models\Action[] */
/* @var $show_consult_button bool */
/* @var $articles_title string */
/* @var $articles \app\models\Article[] */

$educations = [
    'education_main' => 'Образование',
    'education_intern' => 'Интернатура',
    'education_ordinat' => 'Ординатура',
    'education_aspirant' => 'Аспирантура',
    'education_special' => 'Специальность по диплому',
];
$medflex_token = SystemSettings::getParam('common', 'medflex_token');
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<div class="container">
    <h2 class="team-detail__title"><?=$this->context->h1title?></h2>
</div>
<section class="team-detail__main">
    <div class="decor-spots">
        <div class="decor-spots__item"></div>
        <div class="decor-spots__item"></div>
        <div class="decor-spots__item"></div>
    </div>
    <div class="container">
        <div class="team-detail__main__wrapper">
            <div class="team-detail__main__left">
                <img class="team-detail__main__image" src="<?=TextHelper::ImgUrl($member->image_obj->doProp(390, 800))?>" alt="<?=TextHelper::Alt($member->title)?>">
            </div>
            <div class="team-detail__main__center">
                <p class="team-detail__main__title megatext_s_strong">Информация о специалисте</p>
                <div class="team-detail__main__content">
                    <?php if (!empty($member->position)) { ?>
                        <div class="team-detail__main__content__line">
                            <p class="team-detail__main__content__line__title bodytext_m_strong">Специальность:</p>
                            <div class="team-detail__main__content__line__value bodytext_m_strong">
                                <p><?=$member->position?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($member->qualify)) { ?>
                        <div class="team-detail__main__content__line">
                            <p class="team-detail__main__content__line__title bodytext_m_strong">Квалификация:</p>
                            <div class="team-detail__main__content__line__value bodytext_m_strong">
                                <p><?=$member->qualify->title?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($member->academic)) { ?>
                        <div class="team-detail__main__content__line">
                            <p class="team-detail__main__content__line__title bodytext_m_strong">Ученая степень / Ученое звание:</p>
                            <div class="team-detail__main__content__line__value bodytext_m_strong">
                                <p><?=$member->academic?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($member->filials)) { ?>
                        <div class="team-detail__main__content__line">
                            <p class="team-detail__main__content__line__title bodytext_m_strong">Клиника:</p>
                            <div class="team-detail__main__content__line__value bodytext_m_strong">
                                <?php foreach ($member->filials as $filial) { ?>
                                    <a href="#"><?=$filial->title?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($member->specials_arr)) { ?>
                        <div class="team-detail__main__content__line">
                            <p class="team-detail__main__content__line__title bodytext_m_strong">Специализация:</p>
                            <div class="team-detail__main__content__line__value bodytext_m_strong">
                                <ul>
                                    <?php foreach ($member->specials_arr as $special) { ?>
                                        <li><?=$special?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="team-detail__main__right">
                <div class="team-detail__main__price">
                    <p class="bodytext_n">Стоимость приёма</p>
                    <p class="megatext_s_strong">от <span><?=intval($member->min_price)?></span> ₽</p>
                </div>
                <?php if (!empty($member->medflex_id)) { ?>
                    <a href="https://booking.medflex.ru?user=<?=$medflex_token?>&employeeId=<?=$member->medflex_id?>&source=4" target="_blank" class="team-detail__main__btn btn btn_primary bodytext_n_strong">Записаться на приём</a>
                <?php } else { ?>                                
                    <button class="team-detail__main__btn btn btn_primary _open-popup bodytext_n_strong" data-target-id="appointment_member_detail_<?=$member->id?>">Записаться на приём</button>
                <?php } ?>
                <?php if($show_consult_button) { ?>
                    <button class="team-detail__main__btn team-detail__main__btn_online _open-popup bodytext_n_strong" data-target-id="consult_member_detail_<?=$member->id?>">
                        <svg class="icon" width="16" height="16">
                            <use xlink:href="#icon-online"></use>
                        </svg>
                        <span>Записаться на онлайн консультацию</span>
                    </button>
                <?php } ?>
            </div>

        </div>
    </div>
</section>

<section class="tabs">
    <div class="container">
        <div class="tabs__wrapper">
            <ul class="tabs__list">
                <li class="tabs__item bodytext_n_strong _active">Образование</li>
                <li class="tabs__item bodytext_n_strong">Опыт</li>
                <li class="tabs__item bodytext_n_strong">Сертификаты</li>
                <li class="tabs__item bodytext_n_strong">Отзывы</li>
            </ul>
            <div class="tabs__content">
                <div class="tabs__item bodytext_n_strong _active tab__mobile">Образование</div>
                <div class="tabs__block tabs__block_education _active">
                    <?php foreach($educations as $k => $v) { ?>
                        <?php if($member->{$k}) { ?>
                            <div class="tabs__block__line">
                                <p class="tabs__block__line__title bodytext_m_strong"><?=$v?>:</p>
                                <div class="tabs__block__line__value bodytext_m_strong">
                                    <p><?=$member->{$k}?></p>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="tabs__item bodytext_n_strong tab__mobile">Опыт</div>
                <div class="tabs__block tabs__block_experience">
                    <?php if(!empty($member->experiences)) { ?>
                        <?php foreach($member->experiences as $item) { ?>
                            <div class="tabs__block__line">
                                <p class="tabs__block__line__title bodytext_m_strong"><?=$item->from?> – <?=!empty($item->to)?$item->to:'по наст.вр'?></p>
                                <div class="tabs__block__line__value bodytext_m_strong">
                                    <p><?=$item->text?></p>
                                </div>
                            </div>
                        <? } ?>
                    <? } ?>
                </div>
                <div class="tabs__item bodytext_n_strong tab__mobile">Сертификаты</div>
                <div class="tabs__block tabs__block_certificates _navigation-wrapper">
                    <div class="tabs__block_certificates__list _navigation-target" data-media-group>
                        <?php if ($member->certificates_real) { ?>
                            <?php foreach ($member->certificates_real as $item) { ?>
                                <img class="tabs__block_certificates__item _open-media-popup" data-target-id="media-popup" data-content-src="<?=TextHelper::ImgUrl($item->image)?>" src="<?=TextHelper::ImgUrl($item->image_obj->doProp(2000, 235))?>" />
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="filter__arrows _navigation-target">
                        <div class="filter__arrows__item filter__arrows__item_left _navigation__arrow-prev">
                            <svg class="icon">
                                <use xlink:href="#icon-arrow1"></use>
                            </svg>
                        </div>
                        <div class="filter__arrows__item filter__arrows__item_right _navigation__arrow-next">
                            <svg class="icon">
                                <use xlink:href="#icon-arrow1"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="tabs__item bodytext_n_strong tab__mobile">Отзывы</div>
                <div class="tabs__block tabs__block_reviews">
                    <div class="tabs__block_reviews__wrapper">
                        <?php if ($member->reviews_real) { ?>
                            <?php foreach ($member->reviews_real as $item) { ?>
                                <div class="tabs__block_reviews__item">
                                    <div class="tabs__block_reviews__item__head">
                                        <p class="tabs__block_reviews__item__name bodytext_n_strong"><?=$item->name?></p>
                                        <?php if (!empty($item->date)) { ?>
                                            <p class="tabs__block_reviews__item__date bodytext_m"><?=$item->date_obj->format('d [n], Y')?></p>
                                        <?php } ?>
                                    </div>
                                    <p class="tabs__block_reviews__item__text bodytext_l"><?=$item->text?></p>
                                    <div class="tabs__block_reviews__item__footer">
                                        <?php if(!empty($item->text2)) {?>
                                            <div class="accordion _toggle">
                                                <button class="tabs__block_reviews__item__more _toggle__button bodytext_m_strong">Читать весь отзыв</button>
                                            </div>
                                            <div class="tabs__block_reviews__item__more__container _toggle__container">
                                                <p class="bodytext_l"><?=$item->text2?></p>
                                            </div>
                                        <?php } ?>
                                        <?php if($item->source) { ?>
                                            <a class="tabs__block_reviews__item__link bodytext_m_strong" href="<?=$item->source?>" target="_blank" rel="nofollow">Смотреть отзыв в источнике</a>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($item->answer)) { ?>
                                        <div class="tabs__block_reviews__item__answer">
                                            <p class="tabs__block_reviews__item__answer__name bodytext_s_strong">Представитель клиники</p>
                                            <p class="tabs__block_reviews__item__answer__text bodytext_m"><?=$item->answer?></p>
                                            <?php if (!empty($item->answer_date)) { ?>
                                                <p class="tabs__block_reviews__item__answer__date bodytext_m"><?=$item->answer_date_obj->format('d [n] Y, H:i')?></p>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="tabs__block_reviews__sidebar">
                        <p class="tabs__block_reviews__amount">всего <?=count($member->reviews_real)?> <?=TextHelper::getNumEnding(count($member->reviews_real), ['отзыв', 'отзыва', 'отзывов'])?></p>
                        <button class="btn btn_primary tabs__block_reviews__btn _open-popup bodytext_n_strong" data-target-id="member_review_<?=$member->id?>">Оставить отзыв</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php if (!empty($member->pricelist)) { ?>
    <section class="pricelist">
        <div class="container">
            <div class="pricelist__filter"></div>
            <div class="pricelist__head">
                <h2 class="pricelist__title">Стоимость приёма</h2>
                <a class="pricelist__more btn btn_link_arrow bodytext_n_strong" href="<?=Yii::$app->urlManager->createUrl(['price/index'])?>">Смотреть все цены</a>
            </div>

            <div class="pricelist__wrapper">
                <?=$this->render('//service/_pricelist_accordion', ['pricelist' => $member->pricelist])?>
            </div>

            <a class="pricelist__more btn btn_link_arrow bodytext_n_strong" href="<?=Yii::$app->urlManager->createUrl(['price/index'])?>">Смотреть все цены</a>
        </div>
    </section>
<?php } ?>

<?php if ($articles) { ?>
    <section class="articles">
        <div class="container">
            <div class="articles__head">
                <h2 class="articles__title"><?=$articles_title?></h2>
                <a href="<?=$member->blogUrl?>" class="articles__more btn btn_link_arrow bodytext_n_strong _desktop">Смотреть все статьи этого доктора</a>
            </div>
            <div class="swiper swiper_template">
                <div class="swiper-wrapper">
                    <?php foreach ($articles as $article) { ?>
                        <div class="swiper-slide">
                            <?=$this->render('//blog/_item', ['item' => $article]) ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation _mobile">
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <a href="<?=$member->blogUrl?>" class="articles__more btn btn_link_arrow bodytext_n_strong _mobile">Смотреть все статьи этого доктора</a>
        </div>
    </section>
<?php } ?>

<?php if(!empty($member->images_real)) { ?>
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
                    <?php foreach($member->images_real as $image) { ?>
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

<?php if(!empty($member->videos_real)) { ?>
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
                    <?php foreach ($member->videos_real as $video) { ?>
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

<?=$this->render('//components/actions', ['actions' => $actions, 'title' => 'Специальные предложения', 'title_class' => ''])?>

<?=$this->render('//components/form_inline', [
    'form_type' => 'appointment_member',
    'form_image' => $member->modal_image,
    'form_video_id' => $member->modal_video_id,
    'pjax_id' => 'appointment_member_detail_inline_'.$member->id,
    'model' => new RequestAppointmentForm(['member_id' => $member->id]),
    'form_class' => RequestAppointmentForm::class,
    'template' => 'consult',
    'section_class' => 'consultation_wide',
    'options' => [
        'title_tag' => 'h4',
    ],
])?>

<section class="seo wysiwyg">
    <div class="container">
        <div class="seo__wrapper _toggle">
            <?php if(!empty($member->title_seo)) { ?>
                <h1 class="seo__title"><?=$member->title_seo?></h1>
            <?php } ?>
            <?php if (!empty($member->text_seo)) { ?>
                <?=TextHelper::redactorText($member->text_seo, ['<p>' => '<p class="seo__text bodytext_l">'])?>
            <?php } ?>
            <?php if(!empty($member->text_spoiler)) { ?>
                <div class="_toggle__container"><?=$member->text_spoiler?></div>
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

<?php $this->beginBlock('modal-appointment_member_detail_'.$member->id)?>
<?=$this->render('//components/form_modal', [
    'form_type' => 'appointment',
    'form_image' => $member->modal_image,
    'form_video_id' => $member->modal_video_id,
    'modal_id' => 'appointment_member_detail_' . $member->id,
    'pjax_id' => 'appointment_member_detail_' . $member->id,
    'form_class' => RequestAppointmentForm::class,
    'model' => new RequestAppointmentForm(['member_id' => $member->id]),
    'template' => 'form_1',
])?>

<?php if($show_consult_button) { ?>
    <?=$this->render('//components/form_modal', [
        'form_type' => 'consult_services',
        'form_image' => $member->modal_image,
        'form_video_id' => $member->modal_video_id,
        'modal_id' => 'consult_member_detail_' . $member->id,
        'pjax_id' => 'consult_member_detail_' . $member->id,
        'form_class' => RequestConsultForm::class,
        'model' => new RequestConsultForm(['member_id' => $member->id]),
        'template' => 'form_1',
    ])?>
<?php } ?>
<?php $this->endBlock()?>

<?php $this->beginBlock('modal-review_member_detail_'.$member->id)?>
<?=$this->render('//components/form_modal_common', [
    'modal_id' => 'member_review_' . $member->id,
    'pjax_id' => 'member_review_'.$member->id,
    'model' => new RequestReviewForm(['member_id' => $member->id]),
    'template' => 'member_review',
    'title' => 'Оставьте ваш отзыв о враче',
    'button' => 'Оставить отзыв',
    'success_text' => SystemSettings::getParam('form_member_review' , 'success_text', 'Отзыв отправлен!'),
    'popup_class' => 'popup_review',
])?>
<?php $this->endBlock()?>