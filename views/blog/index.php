<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestConsultForm;
use app\models\SystemSettings;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $types array */
/* @var $members \app\models\Member[] */
/* @var $current_member \app\models\Member */
/* @var $pages \app\components\base\Pagination */
/* @var $pages_more \app\components\base\Pagination */
?>

<main class="main">
    <?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
    <div class="container">
        <h2 class="documents__title heading_h1"><?=$this->context->h1title?></h2>
        <section class="blog-content">
            <div class="blog-content__left" id="blog-block">
                <div class="blog-head">
                    <div class="actions">
                        <?php foreach ($types as $k => $v) { ?>
                            <div class="action">
                                <?php if($type == $k) { ?>
                                    <span class="bodytext_m_strong"><?=$v?></span>
                                <?php } else { ?>
                                    <a href="<?=Url::current(['type' => ($k=='news')?null:$k, 'page' => null, 'from' => null, 'more' => null, 'member' => null])?>" data-pjax-block="#blog-block" class="bodytext_m_strong"><?=$v?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if($members) { ?>
                        <div class="blog-sort">
                            <div class="dropdown-authors dropdown">
                                <button class="dropdown__btn">
                                    <a href="#" class="dropdown__current bodytext_m"><?=$current_member?$current_member->title:'Все авторы'?></a>
                                    <svg class="icon icon_close">
                                        <use xlink:href="#icon-arrow3"></use>
                                    </svg>
                                </button>
                                <ul class="dropdown__list">
                                    <li class="dropdown__item" data-value="false">
                                        <a href="<?=Url::current(['member' => null, 'page' => null, 'from' => null, 'more' => null])?>" data-pjax-block="#blog-block" class="dropdown__link bodytext_m">Все авторы</a>
                                    </li>
                                    <?php foreach ($members as $member) { ?>
                                        <li class="dropdown__item" data-value="<?=$member->id?>">
                                            <a href="<?=Url::current(['member' => $member->id, 'page' => null, 'from' => null, 'more' => null])?>" data-pjax-block="#blog-block" class="dropdown__link bodytext_m"><?=$member->title?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="blog-list">
                    <?php foreach ($items as $item) { ?>
                        <div class="blog-list__item">
                            <?=$this->render('_item', ['item' => $item]) ?>
                        </div>
                    <?php } ?>
                </div>

                <?=$pages_more->draw('//components/pager_more_2', 2, ['pjax_block' => '#blog-block', 'class' => 'pagination__btn btn btn_secondary'])?>
                <?=$pages->draw('//components/pager', 2, ['pjax_block' => '#blog-block'])?>
            </div>
            <div class="blog-content__right">
                <div class="decor-spots">
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                </div>
                <div class="blog-content__info">
                    <div class="cta-card">
                        <div class="cta-card__wrapper">
                            <img class="cta-card__image" src="<?=TextHelper::ImgUrl(SystemSettings::getParam('service', 'consult_image', '/assets/front/img/content/test1.jpg', false, 4))?>" alt="<?=TextHelper::Alt(SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?'))?>">
                            <p class="cta-card__title megatext_s_strong"><?=SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?')?></p>
                            <p class="cta-card__text bodytext_l"><?=SystemSettings::getParam('service', 'consult_text', 'Оставьте нам свои данные и мы свяжемся с вами в ближайшее время')?></p>
<!--                            <button class="cta-card__btn btn btn_secondary _open-popup" data-target-id="consult_blog_index">--><?php //=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?><!--</button>-->
                            <button class="cta-card__btn btn btn_secondary _medflex_popup" ><?=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?></button>

                        </div>
                    </div>
                    <button class="blog-content__btn btn btn_primary _medflex_popup bodytext_n_strong" >Записаться на приём</button>
                </div>
            </div>
        </section>
    </div>
</main>

<?php $this->beginBlock('modal-appointment_blog_index')?>
<?=$this->render('//components/form_modal', [
    'form_type' => 'appointment',
    'form_image' => '',
    'form_video_id' => '',
    'modal_id' => 'appointment_blog_index',
    'pjax_id' => 'appointment_blog_index',
    'form_class' => RequestAppointmentForm::class,
    'model' => new RequestAppointmentForm(),
    'template' => 'form_1',
])?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'consult_services',
    'form_image' => '',
    'form_video_id' => '',
    'modal_id' => 'consult_blog_index',
    'pjax_id' => 'consult_blog_index',
    'form_class' => RequestConsultForm::class,
    'model' => new RequestConsultForm(),
    'template' => 'form_1',
])?>
<?php $this->endBlock()?>