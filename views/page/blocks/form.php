<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;
use app\widgets\form\FormWidget;

/**
 * @var Page $item
 * @var PageBlock $block
 */

$formClass = 'app\\models\\forms\\Request'.ucfirst($block->form_type).'Form';
?>

<?php if($block->form_type == 'consult') { ?>
    <section class="consultation consultation_wide">
        <div class="container">
            <div class="consultation__wrapper">
                <div class="consultation__left">
                    <?=FormWidget::widget([
                        'id' => 'page_block_form_'.$block->id,
                        'pjax' => true,
                        'pjax_block_auto' => false,
                        'model' => new $formClass(),
                        'template' => '//widgets/forms/'.$block->form_type,
                        'options' => [
                            'title' => $block->title,
                            'text' => $block->text,
                            'button' => $block->link_title,
                            'success_text' => $block->success_text,
                        ],
                    ])?>
                </div>
                <div class="consultation__right">
                    <?php if ($block->video) { ?>
                        <video class="consultation__video" muted loop playsinline autoplay>
                            <source src="<?=TextHelper::ImgUrl($block->video->video)?>" type="video/mp4">
                        </video>
                    <?php } else { ?>
                        <img class="consultation__image" src="<?=TextHelper::ImgUrl($block->image_obj->doCrop(680, 815))?>" alt="<?=TextHelper::Alt($block->title)?>"/>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if($block->form_type == 'feedback') { ?>
    <section class="contacts-form">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="contacts-form__content">
            <?=FormWidget::widget([
                'id' => 'page_block_form_'.$block->id,
                'pjax' => true,
                'pjax_block_auto' => false,
                'model' => new $formClass(),
                'template' => '//widgets/forms/'.$block->form_type,
                'options' => [
                    'title' => $block->title,
                    'text' => $block->text,
                    'button' => $block->link_title,
                    'success_text' => $block->success_text,
                ],
            ])?>
        </div>
        <div class="contacts-form__image">
            <?php if ($block->video) { ?>
                <video class="consultation__video" muted loop playsinline autoplay>
                    <source src="<?=TextHelper::ImgUrl($block->video->video)?>" type="video/mp4">
                </video>
            <?php } else { ?>
                <img src="<?=TextHelper::ImgUrl($block->image_obj->doCrop(800, 575))?>" alt="<?=TextHelper::Alt($block->title)?>" class="contacts-form__image">
            <?php } ?>
        </div>
    </section>
<?php } ?>