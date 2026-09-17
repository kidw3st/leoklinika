<?php
use app\helpers\base\TextHelper;
use app\models\Action;
use app\models\forms\RequestActionForm;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="cta">
    <div class="container">
        <div class="cta__inner">
            <div class="cta__left">
                <div class="cta__content">
                    <h2 class="cta__title megatext_n"><?=$block->title?></h2>
                    <p class="cta__text megatext_s"><?=$block->description?></p>
<!--                    <a href="#" class="btn btn_primary bodytext_n_strong _open-popup" data-target-id="action_block_--><?php //=$block->id?><!--">--><?php //=empty($block->link_title)?'Оставить заявку':$block->link_title?><!--</a>-->
                    <a href="#" class="btn btn_primary bodytext_n_strong _medflex_popup" ><?=empty($block->link_title)?'Оставить заявку':$block->link_title?></a>
                    <?php if(!empty($block->info)) { ?>
                        <div class="cta__badge">
                            <span class="cta__badge__text"><?=$block->info?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="cta__right">
                <img src="<?=TextHelper::ImgUrl($block->image_obj->doProp(1040, 2000))?>" alt="<?=TextHelper::Alt($block->title)?>" class="cta__img">
            </div>
        </div>
    </div>
</section>
<?php /* ?>
<?php $this->beginBlock('modal-action_block_'.$block->id)?>
<?=$this->render('//components/form_modal', [
    'form_type' => 'block_action',
    'modal_id' => 'action_block_' . $block->id,
    'pjax_id' => 'action_block_' . $block->id,
    'form_class' => RequestActionForm::class,
    'model' => new RequestActionForm(['block_id' => $block->id]),
    'template' => 'form_1',
])?>
<?php $this->endBlock()?>
<?php */ ?>