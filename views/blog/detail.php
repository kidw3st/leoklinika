<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestConsultForm;
use app\models\SystemSettings;

/* @var $this \yii\web\View */
/* @var $item \app\models\News|\app\models\Article  */
/* @var $next \app\models\News|\app\models\Article  */
/* @var $prev \app\models\News|\app\models\Article  */
/* @var $other_items \app\models\News[]|\app\models\Article[]  */
?>

<main class="main">
    <?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
    <div class="container">
        <h2 class="documents__title heading_h1"><?=$this->context->h1title?></h2>
        <section class="blog-detail-content">
            <div class="blog-detail-content__left">
                <?php if($item->image) { ?>
                    <img src="<?=TextHelper::ImgUrl($item->image_obj->doProp(940, 2000))?>" alt="<?=TextHelper::Alt($item->title)?>" class="blog-content__img">
                <?php } ?>
                <div class="blog-detail-content__text">
                    <div class="blog-detail-content__head">
                        <?php if(!empty($item->date)) { ?>
                            <div class="blog-detail-content__date">
                                <span class="bodytext_m"><?=$item->date_obj->format('d.m.Y')?></span>
                            </div>
                        <?php } ?>
                        <?php if(!empty($item->member)) { ?>
                            <div class="blog-detail-content__author">
                                <div class="bodytext_m">
                                    <div class="bodytext_s author-caption">Автор статьи:</div>
                                    <div class="bodytext_m author-name"><?=$item->member->title?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="blog-detail-content__text-inner  wysiwyg">
                        <?=$item->text?>
                    </div>
                    <div class="blog-detail-content__actions">
                        <?php if($prev) { ?>
                            <a href="<?=$prev->selfUrl?>" class="blog-detail-content__action prev action-btn">
                                <div class="action-btn-icon">
                                    <svg class="icon">
                                        <use xlink:href="#icon-arrow2"></use>
                                    </svg>
                                </div>
                                <div class="action-btn-text">
                                    <span class="bodytext_m">Предыдущая статья</span>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if($next) { ?>
                            <a href="<?=$next->selfUrl?>" class="blog-detail-content__action next action-btn">
                                <div class="action-btn-text">
                                    <span class="bodytext_m">Следующая статья</span>
                                </div>
                                <div class="action-btn-icon">
                                    <svg class="icon">
                                        <use xlink:href="#icon-arrow2"></use>
                                    </svg>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="blog-detail-content__right">
                <div class="decor-spots">
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                </div>
                <div class="blog-detail-content__info">
                    <div class="cta-card">
                        <div class="cta-card__wrapper">
                            <img class="cta-card__image" src="<?=TextHelper::ImgUrl(SystemSettings::getParam('service', 'consult_image', '/assets/front/img/content/test1.jpg', false, 4))?>" alt="<?=TextHelper::Alt(SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?'))?>">
                            <p class="cta-card__title megatext_s_strong"><?=SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?')?></p>
                            <p class="cta-card__text bodytext_l"><?=SystemSettings::getParam('service', 'consult_text', 'Оставьте нам свои данные и мы свяжемся с вами в ближайшее время')?></p>
<!--                            <button class="cta-card__btn btn btn_secondary _open-popup" data-target-id="consult_blog_detail">--><?php //=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?><!--</button>-->
                            <button class="cta-card__btn btn btn_secondary _medflex_popup" ><?=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?></button>

                        </div>
                    </div>
                    <button class="blog-detail-content__btn btn btn_primary _medflex_popup bodytext_n_strong" >Записаться на приём</button>
                </div>
            </div>
        </section>

        <?php if($other_items) { ?>
            <section class="articles articles-section-slider">
                <div>
                    <div class="articles__head swiper_template">
                        <h2 class="articles__title">Вам может быть интересно</h2>
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
                    <div class="swiper swiper_template">
                        <div class="swiper-wrapper">
                            <?php foreach ($other_items as $other_item) { ?>
                                <div class="swiper-slide">
                                    <?=$this->render('_item', ['item' => $other_item])?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="swiper-navigation _mobile">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <a href="<?=\app\models\News::indexUrl()?>" class="articles__more btn btn_link_arrow bodytext_n_strong _mobile">Смотреть все статьи</a>
                </div>
            </section>
        <?php } ?>
    </div>
</main>

<?php $this->beginBlock('modal-appointment_blog_detail')?>
<?=$this->render('//components/form_modal', [
    'form_type' => 'appointment',
    'form_image' => '',
    'form_video_id' => '',
    'modal_id' => 'appointment_blog_detail',
    'pjax_id' => 'appointment_blog_detail',
    'form_class' => RequestAppointmentForm::class,
    'model' => new RequestAppointmentForm(),
    'template' => 'form_1',
])?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'consult_services',
    'form_image' => '',
    'form_video_id' => '',
    'modal_id' => 'consult_blog_detail',
    'pjax_id' => 'consult_blog_detail',
    'form_class' => RequestConsultForm::class,
    'model' => new RequestConsultForm(),
    'template' => 'form_1',
])?>
<?php $this->endBlock()?>