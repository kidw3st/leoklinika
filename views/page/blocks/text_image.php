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

<section class="about__cols">
    <div class="container">
        <div class="about__cols__img">
            <img src="<?=TextHelper::ImgUrl($block->image_obj->doCrop(684, 643))?>" alt="<?=TextHelper::Alt($block->title)?>">
        </div>
        <div class="about__cols__right">
            <div class="about__cols__text bodytext_l wysiwyg">
                <?=$block->text?>
            </div>
            <a class="btn btn_link_arrow btn_link_arrow_white bodytext_n_strong _open-popup" href="" data-target-id="text_image_block_<?=$block->id?>"><?=empty($block->link_title)?'Записаться на прием':$block->link_title?></a>
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