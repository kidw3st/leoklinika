<?php
use app\helpers\base\TextHelper;
use app\models\Filial;
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestCallDoctorForm;
use app\models\forms\RequestConsultForm;
use app\models\forms\RequestTaxDeducationForm;
use app\models\Page;
use app\models\SystemSettings;
use yii\caching\TagDependency;

/**
 * @var Page $item
 */
?>

<?php if ($item->show_header) { ?>
    <?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<?php } ?>
<div class="container">
    <?php if ($item->show_header) { ?>
        <h2 class="patients__title"><?=$this->context->h1title?></h2>
    <?php } else { ?>
        <div class="filler"></div>
    <?php } ?>

    <section class="block-content">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="block-content__left wysiwyg">
            <?php if ($item->blocks_real) { ?>
                <?php foreach ($item->blocks_real as $block) { ?>
                    <?php
                    $cacheKey = ['page_blocks', $block->id, Filial::getCurrent()->id];
                    if (($block_render = Yii::$app->cache->get($cacheKey)) === false) {
                        $template = 'blocks/'.$block->block_type;
                        if (file_exists(Yii::getAlias('@app/views/page/').$template.'_' . $item->template . '.php')) {
                            $template .= '_' . $item->template;
                        }

                        $block_render = $this->render($template, ['item' => $item, 'block' => $block]);

                        if (in_array($block->block_type, ['actions', 'advantages', 'banner', 'map', 'news', 'reviews', 'slider', 'text', 'text_image', 'text_seo'])) Yii::$app->cache->set($cacheKey, $block_render, 86400, new TagDependency(['tags' => 'page_blocks']));
                    }
                    ?>
                    <?=$block_render?>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="block-content__right">
            <?php if ($item->blocks_real) { ?>
                <?php foreach ($item->blocks_real as $block) { ?>
                    <?php if ($block->block_type == 'banner_2') { ?>
                        <div class="banner _mobile">
                            <picture class="banner__image">
                                <source class="banner__image_mobile" media="(max-width: 600px)" srcset="<?=TextHelper::ImgUrl($block->image_mobile)?>">
                                <img class="banner__image_desktop" src="<?=TextHelper::ImgUrl($block->image)?>" alt="<?=TextHelper::Alt($block->title)?>">
                            </picture>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <div class="cta-card">
                <div class="cta-card__wrapper">
                    <img class="cta-card__image" src="<?=TextHelper::ImgUrl(SystemSettings::getParam('service', 'consult_image', '/assets/front/img/content/test1.jpg', false, 4))?>" alt="<?=TextHelper::Alt(SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?'))?>">
                    <p class="cta-card__title megatext_s_strong"><?=SystemSettings::getParam('service', 'consult_title', 'Нужна консультация по услуге?')?></p>
                    <p class="cta-card__text bodytext_l"><?=SystemSettings::getParam('service', 'consult_text', 'Оставьте нам свои данные и мы свяжемся с вами в ближайшее время')?></p>
<!--                    <button class="cta-card__btn btn btn_secondary _open-popup" data-target-id="consult_page_--><?php //=$item->id?><!--">--><?php //=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?><!--</button>-->
                    <button class="cta-card__btn btn btn_secondary _medflex_popup" ><?=SystemSettings::getParam('service', 'consult_button', 'Проконсультироваться')?></button>

                </div>
            </div>

            <?php if($item->form) { ?>
<!--                <button class="block-content__btn btn btn_primary _open-popup" data-target-id="--><?php //=$item->form?><!--_page_--><?php //=$item->id?><!--">--><?php //=$item->button_text?><!--</button>-->
                <button class="block-content__btn btn btn_primary _medflex_popup" ><?=$item->button_text?></button>
            <?php } ?>
        </div>
    </section>
</div>

<?php $this->beginBlock('modal-page_detail_'.$item->id)?>
    <?=$this->render('//components/form_modal', [
        'form_type' => 'consult_page',
        'form_image' => '',
        'form_video_id' => '',
        'modal_id' => 'consult_page_'.$item->id,
        'pjax_id' => 'consult_page_'.$item->id,
        'form_class' => RequestConsultForm::class,
        'model' => new RequestConsultForm(['page_id' => $item->id]),
        'template' => 'form_1',
    ])?>

    <?php if($item->form == 'appointment') { ?>
        <?=$this->render('//components/form_modal', [
            'form_type' => 'appointment_page',
            'form_image' => '',
            'form_video_id' => '',
            'modal_id' => 'appointment_page_'.$item->id,
            'pjax_id' => 'appointment_page_'.$item->id,
            'form_class' => RequestAppointmentForm::class,
            'model' => new RequestAppointmentForm(['page_id' => $item->id]),
            'template' => 'form_1',
        ])?>
    <?php } ?>

    <?php if($item->form == 'call_doctor') { ?>
        <?=$this->render('//components/form_modal', [
            'form_type' => 'call_doctor_page',
            'form_image' => '',
            'form_video_id' => '',
            'modal_id' => 'call_doctor_page_'.$item->id,
            'pjax_id' => 'call_doctor_page_'.$item->id,
            'form_class' => RequestCallDoctorForm::class,
            'model' => new RequestCallDoctorForm(['page_id' => $item->id]),
            'template' => 'form_1',
        ])?>
    <?php } ?>

    <?php if($item->form == 'tax') { ?>
        <?=$this->render('//components/form_modal_common', [
            'modal_id' => 'tax_page_'.$item->id,
            'pjax_id' => 'tax_page_'.$item->id,
            'model' => new RequestTaxDeducationForm(['page_id' => $item->id, 'patient' => '1', 'delivery_method' => 'in_person']),
            'template' => 'tax',
            'title' => 'Заказать справку для получения налогового вычета',
            'button' => 'Заказать справку',
            'success_text' => SystemSettings::getParam('form_tax' , 'success_text', 'Справка заказана!'),
            'popup_class' => 'popup_tax',
        ])?>
    <?php } ?>
<?php $this->endBlock()?>