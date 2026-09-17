<?php
use app\helpers\base\TextHelper;
use app\models\Action;
use app\models\forms\RequestAppointmentForm;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="about">
    <div class="container">
        <div class="about__wrapper">
            <div class="about__container">
                <div class="about__left wysiwyg">
                    <?=$block->text?>

                    <button class="block-content__btn btn btn_primary bodytext_n_strong _medflex_popup" ><?=empty($block->link_title)?'Записаться на прием':$block->link_title?></button>
                </div>

                <div class="about__right">
                    <img class="about__image" src="<?=TextHelper::ImgUrl($block->image_obj->doCrop(684, 643))?>" alt="<?=TextHelper::Alt($block->title)?>">
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->beginBlock('modal-text_image_block_'.$block->id)?>
<?=$this->render('//components/form_modal', [
    'form_type' => 'appointment_page_block',
    'modal_id' => 'text_image_block_' . $block->id,
    'pjax_id' => 'text_image_block_' . $block->id,
    'form_class' => RequestAppointmentForm::class,
    'model' => new RequestAppointmentForm(['block_id' => $block->id]),
    'template' => 'form_1',
])?>
<?php $this->endBlock()?>