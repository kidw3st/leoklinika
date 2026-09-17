<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestConsultForm;
use app\widgets\services\ServicesWidget;

/**
 * @var \app\models\Action[] $actions
 * @var \app\models\Service[] $directions
 */

$only_popular = true;
if (Yii::$app->request->get('filter', false) || Yii::$app->request->get('search', false)) $only_popular = false;
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>

<div class="container">
    <h2 class="services-general__title"><?=$this->context->h1title?></h2>
</div>

<?=ServicesWidget::widget([
    'title' => 'Поиск',
    'page_size' => 200,
    'template' => 'search',
    'only_popular' => $only_popular,
    'use_filter_filials' => true,
    'use_filter_directions' => true,
])?>

<?php if (!empty($directions)) { ?>
    <section class="directions">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="directions__head">
                    <h2 class="directions__title">Наши направления</h2>
                    <div class="swiper-navigation ">
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
                <div class="swiper-wrapper<?=count($directions)<=3?' swiper-wrapper_single':''?>">
                    <?php foreach ($directions as $direction) { ?>
                        <div class="swiper-slide">
                            <a href="<?=$direction->selfUrl?>" class="directions__item">
                                <p class="directions__item__title megatext_s_strong"><?=$direction->title?></p>
                                <img src="<?=TextHelper::ImgUrl($direction->image_obj->doCrop(183, 157))?>" alt="<?=TextHelper::Alt($direction->title)?>" class="directions__item__image">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?=ServicesWidget::widget([
    'title' => 'Все услуги',
    'page_more' => true,
    'page_size' => \app\models\SystemSettings::getParam('service', 'all_services_index_items_on_page', 8),
    'template' => 'all_service',
    'default_type' => 'adult',
])?>

<?=$this->render('//components/form_inline', [
    'form_type' => 'consult_services',
    'pjax_id' => 'form_main_services',
    'form_class' => RequestConsultForm::class,
    'template' => 'consult',
    'section_class' => 'consultation_wide',
])?>

<?=$this->render('//components/actions', ['actions' => $actions, 'title' => 'Специальные предложения', 'title_class' => ''])?>